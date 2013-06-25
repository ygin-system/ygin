<?php
class SqlLogRoute extends CFileLogRoute {
  
  const EXECUTING_SQL = 'executing';
  const QUERING_SQL = 'quering';
  const INCLUDED_SQL = 'included';
  /**
   * Типы логируемых запросов
   * @var string
   */
  public $sqlTypes = array(self::INCLUDED_SQL);
  
  /**
   * Запросы, которые необходимо логировать.
   * Работает при типе логирования SqlLogRoute::INCLUDED_SQL
   * @var array of string
   */
  public $includedQueries = array();
  /**
   * Запросы которые будут исключены из лога
   * @var array of string
   */
  public $excludedQueries = array();
  /**
   * Сохранять в лог только сам запрос
   * @var boolean
   */
  public $logOnlyQuery = false;
  
  public function init() {
    parent::init();
    $this->levels = CLogger::LEVEL_PROFILE;
  }
  
  protected function processLogs($logs) {
    $result = array();
    foreach ($logs as $log) {
      if (!($log[1] === CLogger::LEVEL_PROFILE
          && mb_strpos($log[0], 'begin:system.db.CDbCommand') === 0)) {
        continue;
      }
      
      if (($sql = $this->formatLogSql($log[0])) !== false) {
        $result[] = array(
          $sql,
          $log[1],
          $log[2],
          $log[3],
        );
      }
    }
    //Чтобы была пустая строка между группами запросов
    if (!empty($result)) {
      $result[count($result) - 1][0] .= "\n";
    } else {
      return;
    }
    parent::processLogs($result);
  }
   
  protected function formatLogSql($queryString) {
    $executingSqlMark = 'begin:system.db.CDbCommand.execute';
    $queringSqlMark = 'begin:system.db.CDbCommand.query';
    
    $isExecutingSql = true;
    $sqlStart = 0;
    $sqlEnd = mb_strrpos($queryString, ')');
    if (mb_strpos($queryString, $executingSqlMark) !== false) {
      $isExecutingSql = true;
    } elseif(mb_strpos($queryString, $queringSqlMark) !== false) {
      $isExecutingSql = false;
    } else {
      return false;
    }
    $sqlStart = mb_strpos($queryString, '(') + 1;
    
    $queryString = trim(mb_substr($queryString, $sqlStart, $sqlEnd - $sqlStart));
    $queryString = str_replace(array("\n", "\r"), ' ', $queryString);
    
    if (in_array(self::INCLUDED_SQL, $this->sqlTypes)) {
      //Если запрос не находится в включаемых, то пропускаем его
      $inIncl = false;
      foreach ($this->includedQueries as $inclQuery) {
        if (preg_match($inclQuery.'iu', $queryString)) {
          $inIncl = true;
          break;
        }
      }
      if (!$inIncl) {
        return false;
      }
    } else {
      if ($isExecutingSql && !in_array(self::EXECUTING_SQL, $this->sqlTypes)) {
        return false;
      }
      if (!$isExecutingSql && !in_array(self::QUERING_SQL, $this->sqlTypes)) {
        return false;
      }
    }
    
    //Если запрос находится в исключаемых, то пропускаем его
    foreach ($this->excludedQueries as $exclQuery) {
      if (preg_match($exclQuery.'iu', $queryString)) {
        return false;
      }
    }
    $resQueryString = '';
    if (false !== mb_strpos($queryString, '. Bound with '))
    {
        list($query, $params) = explode('. Bound with ', $queryString, 2);
        
        $params = explode(',', $this->encodeSeparator($params, ',', '##COMMA##'));
        $binds  = array();

        foreach ($params as $param)
        {
            list($key,$value) = explode('=', $param, 2);
            $binds[trim($key)] = $this->decodeSeparator(trim($value), '##COMMA##', ',');
        }
        reset($binds);
        //Если ключ числовой, то считаем, что плейсхолдеры параметров знаки вопроса
        if (is_numeric(key($binds))) {
          $resQueryString = $this->replaceQuestionPlaceholders($query, $binds);
        } else {
          $resQueryString = strtr($query, $binds);
        }
    }
    else
    {
        $resQueryString = $queryString;
    }
    //если в конце нет запятой
    if (mb_substr($resQueryString, -1) != ';') {
      $resQueryString .= ';';
    }
    return $resQueryString;
  }
  
  
 private function searchQuotePos($searchStr) {
    $pos = false;
    $offset = 0;
    while (($pos = mb_strpos($searchStr, "'", $offset)) !== false) {
      if ($pos !== 0) {
        if (mb_substr($searchStr, $pos - 1, 1) === '\\') {
          $offset = $pos + 1;
          continue;
        }
      }
      return $pos;
    }
    return $pos;
  }
  /**
   * Кодирует разделитель в строковых параметрах в фразе Bound with,
   * иначе explode по этим парметрам происходит не правильно
   */
  private function encodeSeparator($str, $separator, $replace) {
    $resStr = '';
    $searchStr = $str;
    while (($firstQuotePos = $this->searchQuotePos($searchStr)) !== false) {
      $resStr .= mb_substr($searchStr, 0, $firstQuotePos);
      $searchStr = mb_substr($searchStr, $firstQuotePos + 1);
      $secondQuotePos = $this->searchQuotePos($searchStr);
      $resStr .= "'".str_replace($separator, $replace, mb_substr($searchStr, 0, $secondQuotePos))."'";
      $searchStr = mb_substr($searchStr, $secondQuotePos + 1);
    }
    $resStr .= $searchStr;
    return $resStr;
  }
  
  private function decodeSeparator($str, $search, $separator) {
    return str_replace($search, $separator, $str);
  }
  
  private function replaceQuestionPlaceholders($query, $params) {
    $cnt = 0; //Количество знаков вопроса
    $paramPreparer = create_function('&$cnt', 'return "{{param".($cnt++)."}}";');
    $replaceQuery = preg_replace('~[?]~iuse', '$paramPreparer($cnt)', $query);
    if (count($params) == $cnt) {
      $replArr = array();
      for($i = 0; $i < $cnt; $i++) {
        $curParam = $params[$i];
        $replArr['{{param'.$i.'}}'] = $curParam;
      }
      return strtr($replaceQuery, $replArr);
    }
    return $replaceQuery;
  }
  
  protected function formatLogMessage($message,$level,$category,$time) {
    if ($this->logOnlyQuery) {
      return $message."\n";
    }
    return parent::formatLogMessage($message, $level, $category, $time);
  }
}
