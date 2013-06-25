<?php
class SearchComponent extends CApplicationComponent {

  const SEARCH_MODE_STRICT = 1;
  const SEARCH_MODE_BASE = 2;
  const SEARCH_MODE_SOFT = 3;
  
  //private $page = 1;
  //private $count = 20;
  public $paginator = null;
  private $criteria = null;
    
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
  private $enableEmptyQuery = false;
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
  public function enableEmptyQuery() {
    $this->enableEmptyQuery = true;
  }
  public function disableEmptyQuery() {
    $this->enableEmptyQuery = false;
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
  
  /*private function searchWithEmptyQuery() {
    // Поиск по индексу не осуществляем. Ищем только по дополнительным условиям.

    $result = array();

    if (is_null($this->page) || !is_numeric($this->page) || $this->page < 1) $this->page = 1;
    if (is_null($this->count) || !is_numeric($this->count) || $this->count < 1) $this->count = 20;
    if (is_null($this->lenPreviewText) || !is_numeric($this->lenPreviewText) || $this->lenPreviewText < 1) $this->lenPreviewText = 50;
    
    // Поиск осуществляем только по объектам, для которых есть условия.
    
    $start = ($this->page - 1) * $this->count;
    $count = $this->count;
    $ok = false;
    $total = 0;
    $info = "";
    foreach ($this->conditionSqlList as $k => $v) {
      $ob = Object::getById($k);
      $v = str_replace("<<table_alias>>.", "", $v);
      $where = $v;
      $order = null;
      
      if (isset($this->orderSqlList[$k]) && $this->orderSqlList[$k] != null) {
        $v = $this->orderSqlList[$k];
        $v = str_replace("<<table_alias>>.", "", $v);
        $order = $v;
      }
      $inst = new Instance($k);
      $c = $inst->getCountAllInstance($where);
      $total = $total + $c;
      if ($ok) continue; // Перебираем все остальные объекты для подсчитывания общего количества.
      if ($c < $start) {
        $start = $start - $c;
        continue;
      }
      $info .= $where." | ";
      $data = $inst->getIdInstances($where, $order, $count, $start);
      $c = count($data);
      $ok = false;
      if (count($data) < $count) {
        $count = $count - $c;
        $start = 1;
      } else {
        // Всё, все данные получены. Можем выходить.
        $ok = true;
      }
      
      for ($i = 0; $i < $c; $i++) {
        $res = new SearchResult();
        $res->setIdInstance($data[$i]);
        $res->setIdLang($this->idLocale);
        $res->setIdObject($k);
        $res->setIdParameter($ob->getIdFieldCaption());
        $inst->load($data[$i]);
        $res->setValue($inst->getParamById($ob->getIdFieldCaption()));
        $result[] = $res;
      }
    }
    $this->totalResult = $total;
    Search::addSearchLog(null, $info, "total=".$total."; page=".$this->page."; count=".$this->count);
    return $result;
  }*/
  
  public function startSearch($query) {
    $this->totalResult = null;
    
    /*if ($this->enableEmptyQuery && trim($query) == "") {
      return $this->searchWithEmptyQuery(); 
    }*/
    
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

    // Формируем запрос
    /*$q = new QuerySql();
    
    $selectDomine = '';
    if ($this->idDomain != null || $this->crossDomainSearch) {
      $selectDomine = ',doi.id_domain';
    }
//    $q->setSelect("a.id_object, a.id_instance, a.id_parameter, a.id_lang, a.value".$selectSortColumn);
    $q->setSelect("a.id_object, a.id_instance, a.id_lang, a.value".$selectDomine.$selectSortColumn);
    $q->setFrom($from);
    $q->setWhere($where);
//    $q->setGroupBy("a.id_object, a.id_instance, a.id_lang");
    if ($order != "") $q->setOrderBy($order);

    $q->setRowNum($this->count);
    $q->setRowStart(($this->page - 1) * $this->count);
    */

    if (is_null($this->lenPreviewText) || !is_numeric($this->lenPreviewText) || $this->lenPreviewText < 1) $this->lenPreviewText = 50;
    
    if ($this->paginator == null) {
      $this->paginator = new CPagination();
      $this->paginator->pageSize = 20;
    }
    $this->paginator->applyLimit($criteria);
    
    //$this->sqlQuery = "FROM ".$from." WHERE ".$where;
    $this->criteria = $criteria;
    
    if ($this->logQuery) {
      self::addSearchLog($srcQuery, $criteria->condition." (params: ".print_r($criteria->params, true).")", "page=".$this->paginator->getCurrentPage()."; count=".$this->paginator->getPageSize());
    }    
    
//    $this->sqlQuery = "FROM $from WHERE $where GROUP BY a.id_object, a.id_instance, a.id_lang";
//echo $q->getSqlQuery();

    $result = Search::model()->findAll($criteria);
    foreach ($result AS $r) {
      $r->value = HText::highlightText($r->value, $this->queryArray, $this->highlightTemplate, $this->lenPreviewText);
    }
    /*while ($row = $q->getNextResultObject()) {
      $res = new SearchResult();
      $res->setIdInstance($row->id_instance);
      $res->setIdLang($row->id_lang);
      $res->setIdObject($row->id_object);
      if ($this->idDomain != null || $this->crossDomainSearch) {
        $res->setIdDomain($row->id_domain);
      }
      // Обработка текста
      // формат: ~~~ property text ~~~idParam~~~
      
      
//      $res->setIdParameter($row->id_parameter);
      $res->setValue($this->processText($row->value));
      
      if (isset($this->objectNameList[$res->getIdObject()])) {
        $res->setObjectName($this->objectNameList[$res->getIdObject()]);
      } else {
//        $ob = Object::getById($res->getIdObject());
//        $res->setObjectName($ob->getName());
      }
      
      $result[] = $res;
    }
    $q->freeResult();*/
    return $result;
  }
  
  public function getTotalResult() {
    if (is_null($this->totalResult)) {
      $this->totalResult = Search::model()->count($this->criteria);
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
    $object = $instance->getObjectInstance();
    $params = $object->parameters;
    $data = '';
    foreach($params AS $p) {
      /**
       * @var $p ObjectParameter
       */
      if ($p->isSearch()) {
        $val = $instance->{$p->getFieldName()};
        if ($val != null) $data .= $val.' ';
      }
    }
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
    //!!! Индексация поисковых данных
    Yii::app()->db->createCommand('DELETE FROM da_search_data WHERE id_lang=:id_lang')->execute(array(':id_lang' => $idLang));
    
    //!!!!! По каким свойствам нужно искать
    $pData = array();
    $prs = Yii::app()->db->createCommand()
           ->select('id_object, id_parameter, field_name')
           ->from('da_object_parameters')
           ->where('search=1')
           ->queryAll();
           
    $c = count($prs);
    
    for ($i = 0; $i < $c; $i ++) {
      $id_object = $prs[$i]['id_object'];
      if (!array_key_exists($id_object, $pData)) $pData[$id_object] = array();
      
      $pData[$id_object][] = array('id' => $prs[$i]['id_parameter'], 'name' => $prs[$i]['field_name']);
    }
    //!!!!!
    
    $ids = Yii::app()->db->createCommand()
             ->selectDistinct('id_object')
             ->from('da_object_parameters')
             ->where('search=1')
             ->queryColumn();
             
    if (count($ids)) { // для наследования объектов
      $command = Yii::app()->db->createCommand()
              ->selectDistinct('id_object')
              ->from('da_object');
      $where = '';
      foreach($ids AS $i => $id) {
        if ($i > 0) $where .= ', ';
        $where .= ':id_'.$i;
        $command->params[':id_'.$i] = $id;
      }
      $command->where = 'object_type=4 AND table_name IN ('.$where.')';
      $ids2 = $command->queryColumn();
      $ids = array_merge($ids, $ids2);
    }
    
    $c = count($ids);
    if (!defined('SEARCH_DATA_PORTION')) define('SEARCH_DATA_PORTION', 1000);
    for ($i = 0; $i < $c; $i++) {
      $cur = $ids[$i];
      
      $obj = DaObject::getById($cur, false);
      $model = $obj->getModel();
      
      //echo $cur.' - '.get_class($model).'<br>';
      $startRecord = 0;
      while (true) {
        $data = $model->findAll(array('limit' => SEARCH_DATA_PORTION, 'offset' => $startRecord));
        
        $cData = count($data);
        
        if ($cData == 0) break;
        
        for ($k = 0; $k < $cData; $k++) {
          $id_object = $data[$k]->getIdObject();
          if (array_key_exists($id_object, $pData)) {
            $pNames = $pData[$id_object];
            
            $kf = count($pNames);
            $val = '';
            for ($j = 0; $j < $kf; $j ++) {
              $curName = $pNames[$j]['name'];
              
              $v = $data[$k]->$curName;
              
              if (!is_null($v) && (trim($v) != "")) {
                $val .= $v.' ';
              }
            }
          }
          SearchComponent::replaceData($cur, $data[$k]->getPrimaryKey(), $idLang, $val);
        }
        
        $startRecord += SEARCH_DATA_PORTION;
      }
    }
  }
  /*
  static functions
  */
  /*
  private static function processValue(array $data) {
    $c = count($data);
    $valueItog = "";
    for ($i = 0; $i < $c; $i++) {
      $value = $data[$i][1];
      
      // Обработка данных. Вырезаем все тэги.
      $value = trim($value);
      // Если данных нет, то запись не добавляем.
      if (is_null($value) || $value == "") {
        continue;
      }

      $value = strip_tags($value);
      $value = unHtmlEntities($value);

      $value = cutDoubleChars($value, " ");
      $value = cutDoubleChars($value, "\r");
      $value = cutDoubleChars($value, "\n");
      $value = cutDoubleChars($value, "\r\n");
      $value = cutDoubleChars($value, "\n\r");
      $value = cutDoubleChars($value, "\t");
      $value = str_replace(array("«", "»", "\\", "\"", "\'", "-", "+", ">", "<", "*"), array(" "," ", " ", " ", " ", " ", " ", " ", " ", " "), $value);

//      $valueItog .= "~~~ ".$value." ~~~".$data[$i][0];
      $valueItog .= $value." ";
    }
    return $valueItog;
  }
  
  public static function replaceData($idObject, $idInstance, $idLang, array $data) {
    $valueItog = Search::processValue($data);
    $query = new QuerySql();
    $query->setQuery("SELECT count(*) AS cnt FROM da_search_data WHERE id_object = ".$idObject." AND id_instance = ".$idInstance." AND id_lang = ".$idLang);
    $query->exec();
    $exists = false;
    if ($row = $query->getNextResultObject()) {
      if ($row->cnt == 1) $exists = true;
    }
    $query->freeResult();
    
    if ($exists) {
      if ($valueItog == "") {
        $query->setQuery("DELETE FROM da_search_data WHERE id_object = ".$idObject." AND id_instance = ".$idInstance." AND id_lang = ".$idLang);
        $query->exec();
      } else {
        $query->setQuery("UPDATE da_search_data SET value=".QuerySql::escapeString($valueItog, true)." WHERE id_object=".$idObject." AND id_instance=".$idInstance." AND id_lang=".$idLang);
        $query->exec();
      }
    } else {
      if ($valueItog == "") {
      } else {
        $query->setQuery("INSERT INTO da_search_data (id_object, id_instance, id_lang, value) VALUES ($idObject, $idInstance, $idLang, ".QuerySql::escapeString($valueItog, true).")");
        $query->exec();
      }
    }
  }
  
  public static function addData2Index($idObject, $idInstance, $idLang, array $data) {
    $valueItog = Search::processValue($data);
    if ($valueItog != "") {
      $query = new QuerySql();
      $query->setQuery("SELECT value FROM da_search_data WHERE id_object = ".$idObject." AND id_instance = ".$idInstance." AND id_lang = ".$idLang);
      $query->exec();
      $oldValue = null;
      $exists = false;
      if ($row = $query->getNextResultObject()) {
        $oldValue = $row->value;
        $exists = true;
        $valueItog = $oldValue." ".$valueItog;
      }
      $query->freeResult();
      if ($exists) {
        $query->setQuery("UPDATE da_search_data SET value=".QuerySql::escapeString($valueItog, true)." WHERE id_object=".$idObject." AND id_instance=".$idInstance." AND id_lang=".$idLang);
        $query->exec();
      } else {
        $query->setQuery("INSERT INTO da_search_data (id_object, id_instance, id_lang, value) VALUES ($idObject, $idInstance, $idLang, ".QuerySql::escapeString($valueItog, true).")");
        $query->exec();
      }
    }
  }  
  
  public static function recreateIndex($idLang = 1, $arrayWithBadObject = array()) {
    global $locale;
    $locale->setLocale($idLang);
    $query = new QuerySql();
    $query->setQuery("DELETE FROM da_search_data WHERE id_lang=".$idLang);
    $query->exec();

    $query->setQuery("SELECT DISTINCT id_object FROM da_object_parameters WHERE search=1");
    $query->exec();
    $id = array();
    while ($row = $query->getNextResultObject()) {
      $id[] = $row->id_object;
    }
    $query->freeResult();
    
    if (count($id) > 0) {
      $query->setQuery("SELECT DISTINCT id_object FROM da_object WHERE object_type=4 AND table_name IN (".array2QueryString($id, true).")");
      $query->exec();
      while ($row = $query->getNextResultObject()) {
        if (!in_array($row->id_object, $id)) {
          $id[] = $row->id_object;
        } 
      }
      $query->freeResult();
    }    

    $c = count($id);
    defineif("SEARCH_DATA_PORTION", 1000);
    for ($i = 0; $i < $c; $i++) {
      $cur = $id[$i];  // id_object
      if (in_array($cur, $arrayWithBadObject)) continue;
      $startRecord = 0;
      while (true) {
        $instanceQuery = new InstanceQuery(null, null, SEARCH_DATA_PORTION, $startRecord, true, false, true, false, 2);
        $instanceQuery->setIdDomain(null);
        $instanceQuery->setUsedObjects(array($cur));

        $tmp = new Instance($cur);
        $data = $tmp->getDataByInstanceQuery($instanceQuery, false);

        $cData = count($data);
        if ($cData == 0) break;
        for ($k = 0; $k < $cData; $k++) {
          $instance = $data[$k];
          $countParams = $instance->getCountProps();

          $tempArray = array();
          for ($l = 0; $l < $countParams; $l++) {
            $curParam = $instance->getPropOfArrayIndex($l);
            if ($curParam->getParam()->isSearch()) {
              $v = $curParam->getValue();
              if (!is_null($v) && (trim($v) != "")) {
                $tempArray[] = array($curParam->getParam()->getIdParam(), $v);
              }
              if (count($tempArray) > 0) {
                Search::replaceData($cur, $instance->idInstance, $idLang, $tempArray);
              }
            }
          }
        }
        $startRecord += SEARCH_DATA_PORTION;
      }  // Бесконечный цикл.
    }
    // Индексация локализированных данных
    if ($idLang == 1) {
      global $daDomain;
      $idLocales = $daDomain->getDomainLocalizations();
      $c = count($idLocales);
      for ($i = 0; $i < $c; $i++) {
        $idLocale = $idLocales[$i];
        if ($idLocale == 1) continue;
        Search::recreateIndex($idLocale, $arrayWithBadObject);
      }
    }
  }*/
}

/*
class SearchResult {

  private $idObject = null;
  private $idInstance = null;
  private $idParameter = null;
  private $idLang = null;
  private $value = null;
  
  private $instance = null;
  private $idDomain = null;
  
  public function getInstance() {
    if ($this->instance == null) {
      $idObject = $this->getIdObject();
      //Получаем первичный ключ:
      $pk = ObjectParam::getPrimaryKey($idObject);
      $iq = new InstanceQuery("<<MAIN_ALIAS>>.".$pk->fieldName." = ".$this->getIdInstance(), null, null, null, true, false, true, false, 1);
      $iq->setIdDomain(null);
      $tmp = Object::createInstanceClassByIdObject($idObject);
      $data = $tmp->getDataByInstanceQuery($iq);
      if (count($data) == 1) {
        $this->instance = $data[0];
      }
    }
    return $this->instance;
  }
  
  public function getTitle() {
    $inst = $this->getInstance();
    $result = "";
    if ($inst != null) {
      $result = $inst->getInstanceCaption();
    }
    return $result;
  }
  public function getContent() {
    return $this->getValue();
  }

  public function setIdObject($idObject) {
    $this->idObject = $idObject;
  }
  public function setIdInstance($idInstance) {
    $this->idInstance = $idInstance;
  }
  public function setIdParameter($idParameter) {
    $this->idParameter = $idParameter;
  }
  public function setIdLang($idLang) {
    $this->idLang = $idLang;
  }
  public function setValue($value) {
    $this->value = $value;
  }

  public function getIdObject() {
    return $this->idObject;
  }
  public function getIdInstance() {
    return $this->idInstance;
  }
  public function getIdDomain() {
    return $this->idDomain;
  }
  public function setIdDomain($idDomain) {
    $this->idDomain = $idDomain;
  }
  public function getIdLang() {
    return $this->idLang;
  }
  private function getValue() {
    return $this->value;
  }
}
*/
