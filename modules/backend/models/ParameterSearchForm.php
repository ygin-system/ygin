<?php

class ParameterSearchForm extends CFormModel {

  public $value;
  public $parameter;
  private $_tsBeginValue;
  private $_tsEndValue;
  private $_tsOperator = '';
  /**
   * @var DaObject
   */
  private $_object;
  /**
   * @var SearchParameter[]
   */
  private $_searchParameters = array();
  
  private static $_allowedTypes = array(
    DataType::PRIMARY_KEY,
    DataType::INT,
    DataType::VARCHAR,
    DataType::OBJECT,
    DataType::EDITOR,
    DataType::TEXTAREA,
    DataType::TIMESTAMP,
  );
  
  public function __construct(DaObject $object, $scenario = '') {
    parent::__construct($scenario);
    $this->_object = $object;
    foreach ($object->parameters as $parameter) {
      if (in_array($parameter->getType(), self::$_allowedTypes)) {
        $this->_searchParameters[] = new SearchParameter($parameter);
      }
    }
    if (($defaultParam=$object->getParameterObjectByField($object->getFieldCaption())) != null) {
      $this->parameter = $defaultParam->getIdParameter();
    }
  }
  public function getObject() {
    return $this->_object;
  }
  public function getSearchParameters() {
    return $this->_searchParameters;
  }
  public function getVisibleSearchParameters() {
    return array_filter(
      $this->_searchParameters,
      create_function('$param', 'return $param->visible;')
    );
  }
  public function getHasVisibleSearchParameters() {
    return count($this->getVisibleSearchParameters()) > 0;
  }
  public function toListData() {
    $res = array();
    foreach ($this->getVisibleSearchParameters() as $searchParameter) {
      $res[$searchParameter->parameter->getIdParameter()] = $searchParameter->parameter->caption;
    }
    return $res;
  }
  /**
   * @return ObjectParameter
   */
  public function getSearchObjectParamter() {
    foreach ($this->getVisibleSearchParameters() as $searchParameter) {
      if ($searchParameter->parameter->getIdParameter() == $this->parameter) {
        return $searchParameter->parameter;
      }
    }
    return null;
  }
  public function getSearchCriteria() {
    $criteria = new CDbCriteria();

    if (!($objParameter = $this->getSearchObjectParamter())) {
      return $criteria;
    }
    switch ($objParameter->getType()) {
      case DataType::VARCHAR:
      case DataType::EDITOR:
      case DataType::TEXTAREA:
        $criteria->compare($objParameter->getFieldName(), $this->value, true);
        break;
      case DataType::INT:
      case DataType::PRIMARY_KEY:
        $criteria->compare($objParameter->getFieldName(), $this->value);
        break;
      case DataType::OBJECT:
        $objS = DaObject::getById($objParameter->getAdditionalParameter());
        $primParamS = $objS->getFieldByType(DataType::PRIMARY_KEY);
        $parametersSearch = $objS->parameters;
        $whereSearch = null;
        $i = 0;
        foreach($parametersSearch AS $param) {
          $type = $param->getType();
          if ($type == DataType::VARCHAR) {
            $i++;
            $whereSearch = HText::addCondition($whereSearch, $param->getFieldName().' LIKE :search'.$i, 'OR');
            $criteria->params[':search'.$i] = '%'.$this->value.'%';
          }
        }
        if ($whereSearch != null) {
          $condition = HText::addCondition('', "t.".$objParameter->getFieldName()." IN (SELECT ".$primParamS." FROM ".$objS->table_name." WHERE (".$whereSearch.") )");
          $criteria->addCondition($condition, $condition);
        }
        break;
      case DataType::TIMESTAMP:
        if ($this->_tsBeginValue && $this->_tsEndValue) {
          $criteria->addBetweenCondition($objParameter->getFieldName(), $this->_tsBeginValue, $this->_tsEndValue);
        } else {
           $criteria->compare($objParameter->getFieldName(), $this->_tsOperator.$this->_tsBeginValue);
        }
        break;
    }
    return $criteria;
  }
  protected function beforeValidate() {
    $this->value = trim($this->value);
    $exists = false;
    foreach ($this->getVisibleSearchParameters() as $searchParam) {
      if ($searchParam->parameter->getIdParameter() == $this->parameter) {
        $exists = true;
        break;
      }
    }
    if (!$exists) return false;
    if ($objParameter = $this->getSearchObjectParamter()) {
      if ($objParameter->getType() == DataType::TIMESTAMP && !$this->parseTimestamp()) {
        return false;
      }
    }
    
    return parent::beforeValidate();
  }
  private function parseTimestamp() {
    $date = '';
    $op = '';
    if(preg_match('/^(?:\s*(<>|<=|>=|<|>|=))?(.*)$/',$this->value,$matches)) {
      $date = $matches[2];
      $op = $matches[1];
    } else {
      $date = $this->value;
    }
    $parsePattern = '';
    if (preg_match('/^\d{2}.\d{2}.\d{2}$/', $date)) {
      $parsePattern = 'dd.MM.yy';
    } elseif (preg_match('/^\d{2}.\d{2}.\d{2} \d{2}:\d{2}$/', $date)) {
      $parsePattern = 'dd.MM.yy HH:mm';
    } elseif (preg_match('/^\d{2}.\d{2}.\d{2} \d{2}:\d{2}:\d{2}$/', $date)) {
      $parsePattern = 'dd.MM.yy HH:mm:ss';
    }
    if (($tsBegin = CDateTimeParser::parse($date, $parsePattern)) === false) {
      return false;
    }
    $this->_tsBeginValue = $tsBegin;
    $beginDay = HDate::getTimestampOnBeginning($tsBegin, HDate::BEGINNING_DAY);
    $endDay = $beginDay + 86399;
    if ($tsBegin == $beginDay) {//если выбрали день (без времени)
      if (empty($op) || $op == '=') {
        $this->_tsEndValue = $endDay; //до конца дня
      } elseif ($op == '>' || $op == '<=') {
        $this->_tsBeginValue = $endDay;
      }
    }
    $this->_tsOperator = $op;
    return true;
  }
  public function rules() {
    return array(
      array('parameter, value', 'required'),
      array('parameter, value', 'length', 'max'=>255),
    );
  }

  /**
   * Declares attribute labels.
   */
  public function attributeLabels() {
    return array(
      'parameter' => 'параметр',
      'value' => 'строка поиска',
    );
  }
  
}
