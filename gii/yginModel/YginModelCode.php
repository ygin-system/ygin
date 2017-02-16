<?php
Yii::import('gii.generators.model.ModelCode');
class YginModelCode extends ModelCode {
  public $baseClass='DaActiveRecord';
  public $tsBehavior = false;
  public $tsBehaviorCreateAttribute = '';
  public $tsBehaviorUpdateAttribute = '';
  
  private $_object = null;
  
  
  public function init()
  {
    parent::init();
    if (!$this->tablePrefix) {
      $this->tablePrefix = 'pr_';
    }
  }
  
  public function getObjectId() {
    return $this->getObject()->id_object;
  }
  /**
   * @return DaObject
   */
  public function getObject() {
    if ($this->_object === null) {
      $this->_object = DaObject::model()->with('parameters')->findByAttributes(array('table_name' => $this->tableName));
    }
    return $this->_object;
  }
  
  /**
   * @param string $name
   * @return ObjectParameter
   */
  protected  function getParameterByColumnName($name) {
    $object = $this->getObject();
    foreach ($object->parameters as $parameter) {
      if ($parameter->field_name == $name) {
        return $parameter;
      }
    }
  }
  public function generateLabels($table)
  {
    $labels=array();
    foreach($table->columns as $column)
    {
      $parameter = $this->getParameterByColumnName($column->name);
      if ($parameter) {
        if ($parameter->id_parameter_type == DataType::PRIMARY_KEY) {
          $labels[$column->name] = 'ID';
        } else {
          $labels[$column->name] = $parameter->caption;
        }
      } else {
        $label=ucwords(trim(strtolower(str_replace(array('-','_'),' ',preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $column->name)))));
        $label=preg_replace('/\s+/',' ',$label);
        if(strcasecmp(substr($label,-3),' id')===0)
          $label=substr($label,0,-3);
        if($label==='Id')
          $label='ID';
        $labels[$column->name]=$label;
      }
    }
    return $labels;
  }
  public function generateRelations() {
    $relations = parent::generateRelations();
    $className = $this->generateClassName($this->tableName);
    foreach ($this->getObject()->parameters as $parameter) {
      //Формируем relations для свойства "Объект (внешний ключ)"
      if ($parameter->id_parameter_type == DataType::OBJECT) {
        $refObject = DaObject::getById($parameter->add_parameter);
        $refClassName = $this->generateClassName($this->removeTablePrefix($refObject->table_name));
        $relationName = $this->generateRelationName($refObject->table_name, $this->removeFieldNamePrefix($parameter->field_name), false);
        if (!isset($relations[$className][$relationName])) {
          $relations[$className][$relationName]="array(self::BELONGS_TO, '$refClassName', '$parameter->field_name')";
        }
      } elseif ($parameter->id_parameter_type == DataType::FILE) {
        $refClassName = 'File';
        $relationName = $this->generateRelationName('da_files', $this->removeFieldNamePrefix($parameter->field_name), false);
        if ($relationName == $this->removeFieldNamePrefix($parameter->field_name)) {
          $relationName .= 'File';
        }
        if (!isset($relations[$className][$relationName])) {
          $relations[$className][$relationName]="array(self::BELONGS_TO, '$refClassName', '$parameter->field_name')";
        }
      } elseif ($parameter->id_parameter_type == DataType::REFERENCE) {
        //TODO Подумать нужно ли?
        /*
        $refClassName = 'ReferenceElement';
        $relationName = $this->generateRelationName('da_reference_element', $this->removeFieldNamePrefix($parameter->field_name), false);
        if (!isset($relations[$className][$relationName])) {
          $relations[$className][$relationName]="array(self::BELONGS_TO, '$refClassName', '$parameter->field_name'), 'on' => 'id_reference = $parameter->add_parameter'";
        }
        */
      }
    }
    //формируем relations для подчиненных таблиц
    $parameters = ObjectParameter::model()->findAllByAttributes(array(
      'id_parameter_type' => DataType::OBJECT,
      'add_parameter' => $this->getObject()->id_object
    ));
    foreach ($parameters as $parameter) {
      $refObject = DaObject::getById($parameter->id_object);
      $refClassName = $this->generateClassName($this->removeTablePrefix($refObject->table_name));
      $relationName = $this->generateRelationName($refObject->table_name, $this->removeTablePrefix($refObject->table_name), true);
      if (!isset($relations[$className][$relationName])) {
        $relations[$className][$relationName]="array(self::HAS_MANY, '$refClassName', '$parameter->field_name')";
      }
    }
    return $relations;
  }
  protected function removeFieldNamePrefix($fieldName) {
    if (substr($fieldName, 0, 3) == 'id_') {
      return substr($fieldName, 3);
    }
    return $fieldName;
  }
  protected function removeTablePrefix($tableName) {
    $tableName = $this->removePrefix($tableName, false);
   
    if (in_array(substr($tableName, 0, 3), array('pr_', 'da_'))) {
      return substr($tableName, 3);
    }
    return $tableName;
  }
  public function attributeLabels()
  {
    return array_merge(parent::attributeLabels(), array(
      'tsBehavior'=>'CTimestampBehavior',
    ));
  }
}