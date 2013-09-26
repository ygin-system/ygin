<?php
class SearchComponent extends CApplicationComponent {

  const SEARCH_MODE_STRICT = 1;
  const SEARCH_MODE_BASE = 2;
  const SEARCH_MODE_SOFT = 3;

  //private $page = 1;
  //private $count = 20;
  public $paginator = null;

  private $baseCriteria = null;
  public $criteria;

    
  private $conditionSqlList = array();
  private $orderSqlList = array();
  private $objectsOrder = array();
  private $objectSearchList = array();
  private $objectNotSearchList = array();
  private $objectNameList = array();
  private $searchMode = self::SEARCH_MODE_BASE;
  private $idDomain = null;
  
  private $minQuery = 3;
  private $maxQuery = 128;
  
  private $lenPreviewText = 50;
  private $highlightTemplate = '<b>%s</b>';
  
  private $totalResult = null;
  //private $sqlQuery = null;
  private $queryArray = array();
  private $idLocale = Localization::LOCALE_MAIN;
  private $stopList = array();
  private $crossDomainSearch = false;
  
  public $logQuery = true;
    
  public function setCrossDomainSearch($value) {
    $this->crossDomainSearch = $value;
  }
  
  public function setStopList(Array $stopList) {
    $this->stopList = $stopList;
  }
  public function setHighlightTemplate($template) {
    $this->highlightTemplate = $template;
  }
  public function setObjectNotSearchList(Array $arrayList) {
    $this->objectNotSearchList = $arrayList;
  }
  public function setObjectSearchList(Array $arrayList) {
    $this->objectSearchList = $arrayList;
  }
  public function addObjectInSearchList($idObject) {
    if (!in_array($idObject, $this->objectSearchList)) {
      $this->objectSearchList[] = $idObject;
    }
  }
  public function setLenPreviewText($len) {
    $this->lenPreviewText = $len;
  }
  public function getLenPreviewText() {
    return $this->lenPreviewText;
  }
  
  /*public function setPage($page) {
    $this->page = $page;
  }
  public function setCount($count) {
    $this->count = $count;
  }
  public function getPage() {
    return $this->page;
  }
  public function getCount() {
    return $this->count;
  }*/
  
  public function addCondition($idObject, $value) {
    $this->conditionSqlList[$idObject] = $value;
  }
  public function addOrder($idObject, $value) {
    $this->orderSqlList[$idObject] = $value;
  }
  public function setObjectsOrder(Array $order) {
    $this->objectsOrder = $order;
  }
  public function setIdDomain($idDomain) {
    $this->idDomain = $idDomain;
  }
  
  public function setObjectName($idObject, $name) {
    $this->objectNameList[$idObject] = $name;
  }
  public function setSearchMode($mode) {
    $this->searchMode = $mode;
  }
  public function setMinQuery($val) {
    $this->minQuery = $val;
  }
  public function setMaxQuery($val) {
    $this->maxQuery = $val;
  }
  public function setIdLocale($idLocale) {
    $this->idLocale = $idLocale;
  }
  
  public function getQueryArray() {
    return $this->queryArray;
  }
  
  public static function addSearchLog($phrase, $query, $info) {
    $sh = new SearchHistory();
    $sh->phrase = $phrase;
    $sh->query = $query;
    $sh->info = $info;
    $sh->date = time();
    $sh->ip = HU::getUserIp();
    $sh->save();
  }
  
  public function startSearch($query) {
    $this->totalResult = null;
    
    $srcQuery = $query;
    // Если будут ошибки, то выпадет исключение.
    $query = $this->processQuery($query);
    //$this->sqlQuery = $query;
    
    $criteria = new CDbCriteria();
    $criteria->addCondition("MATCH value AGAINST (:q IN BOOLEAN MODE) AND id_lang=:l");
    $criteria->params = array(":q" => $query, ":l" => $this->idLocale);
    
    //$from = "da_search_data a";
    //$where = "MATCH (a.value) AGAINST (? IN BOOLEAN MODE)";
    //" AND a.id_lang=".$this->idLocale;
    
    /*if ($this->idDomain != null || $this->crossDomainSearch) {
      $from .= " JOIN da_object_instance doi ON a.id_object=doi.id_object AND a.id_instance=doi.id_instance";
      if ($this->idDomain != null) {
        $where = "doi.id_domain=".$this->idDomain." AND ".$where;
      }
    }
    $order = "";
    $iAlias = 0;
    foreach ($this->conditionSqlList as $k => $v) {
      $iAlias++;
      $alias = "a".$iAlias;
      if ($iAlias == 1) {
        $where .= " AND (";
      }
      
      $ob = Object::getById($k);
      $table = $ob->getTableName();
      $pk = ObjectParam::getPrimaryKey($k);
      
      $v = str_replace("<<table_alias>>", $alias, str_replace("<<main_alias>>", "a", $v));
      // $from = $from." LEFT JOIN ".$table." ".$alias." ON a.id_object=".$k." AND a.id_instance=".$alias.".".$pk->getFieldname()." AND ".$v;
      $from = $from." LEFT JOIN ".$table." ".$alias." ON a.id_object=".$k." AND a.id_instance=".$alias.".".$pk->getFieldname();

      if ($iAlias > 1) {
        // $where .= " OR ";
        $where .= " AND ";
      }
      $where .= "( (".$v." AND a.id_object=".$k.") OR a.id_object <> ".$k." )";
      
      // AND a1.visible=1
      // AND ((a1.visible=1 AND a.id_object=100) OR (a1.visible IS NULL AND a.id_object <>100))
       //$where .= " AND ((a1.visible=1 AND a.id_object=100) OR (a1.visible IS NULL AND a.id_object <>100))";
      
      if (isset($this->orderSqlList[$k]) && $this->orderSqlList[$k] != null) {
        $v = $this->orderSqlList[$k];
        $v = str_replace("<<table_alias>>", $alias, $v);
        $order .= $v.", ";
        $this->orderSqlList[$k] = null;
      }
    }
    if ($iAlias > 0) {
      $where .= ")";
    }*/

    // Сортировка данных по объекту.
    /*$selectSortColumn = "";
    $c = count($this->objectsOrder);
    for ($i = 0; $i < $c; $i++) {
      $selectSortColumn .= "WHEN ".$this->objectsOrder[$i]." THEN ".$i." ";
    }
    if ($c > 0) {
      $order = "sort_column ASC, ".$order;
      $selectSortColumn = ", (CASE a.id_object ".$selectSortColumn."ELSE ".$c." END) AS sort_column";
    }
    
    foreach ($this->orderSqlList as $k => $v) {
      if ($v == null) continue;

      $iAlias++;
      $alias = "a".$iAlias;

      $ob = Object::getById($k);
      $table = $ob->getTableName();
      $pk = ObjectParam::getPrimaryKey($k);

      $v = str_replace("<<table_alias>>", $alias, $v);
      $from = $from." LEFT JOIN ".$table." ".$alias." ON a.id_object=".$k." AND a.id_instance=".$alias.".".$pk->getFieldname();

      $order .= $v.", ";
      $this->orderSqlList[$k] = null;
    }
    if ($order != "") {
      $order = mb_substr($order, 0, mb_strlen($order) - 2);
    }*/
    
    if (count($this->objectSearchList) > 0) {
      //$str = array2QueryString($this->objectSearchList);
      //$where .= " AND a.id_object IN ($str)";
      $criteria->addInCondition("id_object", $this->objectSearchList);
    }
    if (count($this->objectNotSearchList) > 0) {
      //$str = array2QueryString($this->objectNotSearchList);
      //$where .= " AND a.id_object NOT IN ($str)";
      $criteria->addNotInCondition("id_object", $this->objectNotSearchList);
    }

    if (is_null($this->lenPreviewText) || !is_numeric($this->lenPreviewText) || $this->lenPreviewText < 1) $this->lenPreviewText = 50;
    
    if ($this->paginator == null) {
      $this->paginator = new CPagination();
      $this->paginator->pageSize = 20;
    }
    $this->paginator->applyLimit($criteria);

    if ($this->criteria !== null) $criteria->mergeWith($this->criteria);

    $this->baseCriteria = $criteria;
    
    if ($this->logQuery) {
      self::addSearchLog($srcQuery, $criteria->condition." (params: ".print_r($criteria->params, true).")", "page=".$this->paginator->getCurrentPage()."; count=".$this->paginator->getPageSize());
    }    
    
    $result = Search::model()->findAll($criteria);
    foreach ($result AS $r) {
      $r->value = HText::highlightText($r->value, $this->queryArray, $this->highlightTemplate, $this->lenPreviewText);
    }
    return $result;
  }
  
  public function getTotalResult() {
    if (is_null($this->totalResult)) {
      $this->totalResult = Search::model()->count($this->baseCriteria);
      $this->paginator->setItemCount($this->totalResult);
    }
    return $this->totalResult;
  }

  public function processQuery($q, $type=1) {
    // Общая проверка
    if (is_null($q) || trim($q) == "") {
      throw new ErrorException("Задан пустой поисковый запрос.");
    } else if (mb_strlen($q) < $this->minQuery) {
      throw new ErrorException("Запрос слишком короткий.");
    } else if (mb_strlen($q) > $this->maxQuery) {
      throw new ErrorException("Запрос слишком длинный.");
    }

    $q = str_replace(array("«", "»", "\\", "\"", "\'", "-", "+", ">", "<", "*"), array(" "," ", " ", " ", " ", " ", " ", " ", " ", " "), $q);
    
    // process stop list
    $c = count($this->stopList);
    $pattern = "";
    for ($i = 0; $i < $c; $i++) {
      $stop = trim($this->stopList[$i]);
      if ($stop == "") continue;
      $stop = str_replace("*", "\S*", $stop);
      if ($pattern != "") $pattern .= "|";
      $pattern .= "(".$stop.")";
    }
    if ($pattern != "") {
      $q = preg_replace("/".$pattern."/i", "", $q);
    }
    
    $a = explode(" ", $q);
    $q = "";
    
    foreach ($a as $k => $v) {
      if (trim($v) == '') {
        continue;
      }
      if (mb_strlen($v) < $this->minQuery && $this->searchMode != self::SEARCH_MODE_STRICT) {
        continue;
      }
      if ($type == 1) {
        if ($this->searchMode == self::SEARCH_MODE_BASE) {
          $q = $q."+".$v."* ";
          $this->queryArray[] = $v;
        } else if ($this->searchMode == self::SEARCH_MODE_SOFT) {
          $v = HText::cutEnding($v);
          $q = $q."+".$v."* ";
          $this->queryArray[] = $v;
        } else if ($this->searchMode == self::SEARCH_MODE_STRICT) {  // строгий
          $q = $q.$v." ";
        }
      } else if ($type == 2) {
        if ($this->searchMode == self::SEARCH_MODE_BASE) {
          $this->queryArray[] = $v;
          $v = $v."%";
        } else if ($this->searchMode == self::SEARCH_MODE_SOFT) {
          $v = HText::cutEnding($v);
          $this->queryArray[] = $v;
          $v = $v."%";
        } else if ($this->searchMode == self::SEARCH_MODE_STRICT) {  // строгий
          $v .= " ";
        }
        if ($q == "") $q = "%";
        $q = $q.$v;
      }
      
    }
    $q = trim($q);
    if ($this->searchMode == self::SEARCH_MODE_STRICT) {
      $this->queryArray[] = $q;
      $q = "\"$q\"*";
    }
    
    return $q;
  }

  private static function processValue($data) {
    // Обработка данных. Вырезаем все тэги.
    $value = trim($data);
    // Если данных нет, то запись не добавляем.
    if (is_null($value) || $value == "") {
      return '';
    }

    $value = strip_tags($value);
    $value = html_entity_decode($value, ENT_QUOTES, 'UTF-8');

    $value = HText::cutDoubleChars($value, " ");
    $value = HText::cutDoubleChars($value, "\r");
    $value = HText::cutDoubleChars($value, "\n");
    $value = HText::cutDoubleChars($value, "\r\n");
    $value = HText::cutDoubleChars($value, "\n\r");
    $value = HText::cutDoubleChars($value, "\t");
    $value = str_replace(array("«", "»", "\\", "\"", "\'", "-", "+", ">", "<", "*"), array(" "," ", " ", " ", " ", " ", " ", " ", " ", " "), $value);

    return $value;
  }

  public static function replaceIndex(DaActiveRecord $instance, $idLang=1) {
    $data = $instance->getDataForSearch();
    self::replaceData($instance->getIdObject(), $instance->getIdInstance(), $idLang, $data);
  }
  public static function replaceData($idObject, $idInstance, $idLang, $data) {
    $valueItog = SearchComponent::processValue($data);
    
    $prs = Yii::app()->db->createCommand()
         ->select('id_object')
         ->from('da_search_data')
         ->where('id_object = :obj AND id_instance = :inst AND id_lang = :lang', array(':obj' => $idObject, ':inst' => $idInstance, ':lang' => $idLang))
         ->queryAll();
         
    $exists = count($prs) == 1;
    
    if ($exists) {
      if ($valueItog == "") {
        $sql = 'DELETE FROM da_search_data WHERE id_object = :idObject AND id_instance = :idInstance AND id_lang = :idLang';
        $com = Yii::app()->db->createCommand($sql);
        $com->execute(array(':idObject' => $idObject, ':idInstance' => $idInstance, ':idLang' => $idLang));
      } else {
        $sql = 'UPDATE da_search_data SET value=:value WHERE id_object=:idObject AND id_instance=:idInstance AND id_lang=:idLang';
        $com = Yii::app()->db->createCommand($sql);
        $com->execute(array(':value' => $valueItog, ':idObject' => $idObject, ':idInstance' => $idInstance, ':idLang' => $idLang));
      }
    } else {
      if ($valueItog != "") {
        $sql = 'INSERT INTO da_search_data(id_object, id_instance, id_lang, value) VALUES(:idObject, :idInstance, :idLang, :value)';
        $com = Yii::app()->db->createCommand($sql);
        $com->execute(array(':value' => $valueItog, ':idObject' => $idObject, ':idInstance' => $idInstance, ':idLang' => $idLang));
      }
    }
  }
  
  public static function recreateIndex($idLang = 1, $arrayWithBadObject = array()) {
    // Удаляем старые данные
    Yii::app()->db->createCommand('DELETE FROM da_search_data WHERE id_lang=:id_lang')->execute(array(':id_lang' => $idLang));
    
    // По каким свойствам нужно искать
    $ids = Yii::app()->db->createCommand()
        ->selectDistinct('id_object')
        ->from('da_object_parameters')
        ->where('search=1')
        ->queryColumn();

    $searchDataPortion = Yii::app()->getModule('search')->searchDataPortion;
    if (intval($searchDataPortion) < 1) $searchDataPortion = 1000;
    foreach($ids AS $idObject) {
      $obj = DaObject::getById($idObject);
      $model = $obj->getModel();
      $startRecord = 0;
      while (true) {
        $data = $model->findAll(array('limit' => $searchDataPortion, 'offset' => $startRecord));
        foreach($data AS $instance)
          self::replaceIndex($instance, $idLang);
        if (count($data) == 0 || count($data) < $searchDataPortion) break;
        $startRecord += $searchDataPortion;
      }
    }
  }
}
