<?php
class ExportForm extends CFormModel {

    
  public $objectId;
  public $objectParameters;
  public $tableName;
  public $objectName;
  public $newObjectId;
  public $newObjectParameters;
  public $checkAttributes;
  public $isDataExport;
  public $isPermissionExport;

  public function attributeLabels() {
    return array(
      'objectId' => 'Экспортируемый объект',
      'objectName' => 'Название нового объекта',
      'tableName' => 'Таблица для нового объекта'
    );
  }
  
  public function rules() {
    return array(
        array('objectId, objectName, tableName', 'required'),
        array('objectParameters, newObjectParameters, checkAttributes', 'safe'),
        array('isDataExport, isPermissionExport', 'boolean'),
        array('data', 'safe'),
    );
  }


  protected function getPopulatedData($fieldNames, $model, $override = array()) {
    $result = array();
    foreach ($fieldNames as $name) {
      if ($model[$name] === '' || $model[$name] === null) {
        $result[$name] = 'NULL';
      } else {
        $result[$name] = Yii::app()->db->quoteValue($model[$name]);
      }
    }
    $result = CMap::mergeArray($result, $override);
    return $result;
  }

  protected function getInsertStatement($tableName, $populatedData) {
    return "INSERT IGNORE INTO `".$tableName."`(`".implode("`, `", array_keys($populatedData))."`)\n".
        "VALUES (".implode(', ', $populatedData).");\n";
  }
  
  public function getDump() {
    $this->newObjectId = $this->objectId."-export";

    $sql = "START TRANSACTION;\n";
    $sql .= $this->getInsertObject(); //da_object
    $sql .= $this->getInsertParameters(); //da_object_parameters
    $sql .= $this->getInsertTable(); // table
    $sql .= $this->getInsertAuthItems(); //da_auth_item, da_auth_item_child
    $sql . "\n";
    if ($this->isDataExport) {
      $sql .= $this->getInsertTableData(); //table data
    }
    $sql .= 'COMMIT;';
    Yii::app()->request->sendFile('dump.sql', $sql);
  }

  private function getInsertObject() {
    $object = DaObject::model()->findByPk($this->objectId);
    $fields = ObjectParameter::model()->findAll('`id_object` = ?', array($this->objectId));
    $fieldNames = array(
      'id_object',
      'name',
      'id_field_order',
      'order_type',
      'table_name',
      'id_field_caption',
      'object_type',
      'folder_name',
      'parent_object',
      'sequence',
      'use_domain_isolation',
      'field_caption',
      'yii_model',
    );
    $sql = $this->getInsertStatement('da_object', $this->getPopulatedData($fieldNames, $object, array(
      'id_object' => "'{$this->newObjectId}'",
      'name' => "'{$this->objectName}'",
      'table_name' => "'{$this->tableName}'",
      'id_field_caption' => 'NULL',
      'id_field_order' => 'NULL'
    )));
    $sql .= "\n";
    return $sql;
  }

  private function getInsertParameters() {
    $fieldNames = array(
      'id_object',
      'id_parameter',
      'id_parameter_type',
      'sequence',
      'widget',
      'caption',
      'field_name',
      'add_parameter',
      'default_value',
      'not_null',
      'sql_parameter',
      'is_unique',
      'group_type',
      'need_locale',
      'search',
      'is_additional',
      'hint',
    );
    $sql = "";
    foreach($this->checkAttributes as $i => $checkValue) {
      if (!($parameterName = $this->newObjectParameters[$i])) continue;
      $objectParameter = ObjectParameter::model()->find(array(
        'condition' => 'id_object = :obj AND id_parameter = :param',
        'params' => array(':obj' => $this->objectId, ':param' => $this->objectParameters[$i])
      ));
      $sql .=$this->getInsertStatement('da_object_parameters', $this->getPopulatedData($fieldNames, $objectParameter, array(
        'id_object' => "'{$this->newObjectId}'",
        'id_parameter' => "'ygin-{$this->newObjectId}-{$parameterName}'",
        'field_name' => "'{$parameterName}'"
      )));
      $sql .= "\n";
    }
    return $sql;
  }

  private function getInsertTable() {
    $sql = "";
    $primaryKeyText = "";
    $uniqueText = "";
    $tableColumns = array();
    foreach($this->checkAttributes as $i => $checkValue) {
      if (!($parameterName = $this->newObjectParameters[$i])) continue;
      $objectParameter = ObjectParameter::model()->find(array(
        'condition' => 'id_object = :obj AND id_parameter = :param',
        'params' => array(':obj' => $this->objectId, ':param' => $this->objectParameters[$i])
      ));
      $tableColumns[$objectParameter->id_parameter] = "`{$parameterName}`" . " " . DataType::getSqlType($objectParameter->getDataType());
      if ($objectParameter->default_value) {
        $tableColumns[$objectParameter->id_parameter] .= " DEFAULT '{$objectParameter->default_value}'";
      }
      if ($objectParameter->isRequired()) {
        $tableColumns[$objectParameter->id_parameter] .= " NOT NULL ";
      }
      if ($objectParameter->isUnique()) {
        $uniqueText = ", UNIQUE (`{$objectParameter->field_name}`)";
        //$tableColumns[$objectParameter->id_parameter] .= " UNIQUE ";
      }
      if ($objectParameter->getDataType() == DataType::PRIMARY_KEY) {
        $primaryKeyText = ", PRIMARY KEY (`{$objectParameter->field_name}`)";
        $tableColumns[$objectParameter->id_parameter] .= " AUTO_INCREMENT ";
      }
    }
    $sql .= "CREATE TABLE IF NOT EXISTS `" . $this->tableName . "`(" . implode(',', $tableColumns);
    $sql .= $primaryKeyText;
    $sql .= $uniqueText;
    $sql .= ");";
    return $sql;
  }

  private function getInsertTableData() {
    $sql = "";
    $oldListFields = array();
    $newListFields = array();
    foreach($this->checkAttributes as $i => $checkValue) {
      if (!($parameterName = $this->newObjectParameters[$i])) continue;
      $objectParameter = ObjectParameter::model()->find(array(
        'condition' => 'id_object = :obj AND id_parameter = :param',
        'params' => array(':obj' => $this->objectId, ':param' => $this->objectParameters[$i])
      ));
      $oldListFields[] = $objectParameter->field_name;
      $newListFields[] = $parameterName;
    }
    $count = count($oldListFields);
    //$sql .= "INSERT IGNORE INTO `" .$this->tableName . "`(`".implode("`, `", $newListFields)."`)\n";
    $model = DaObject::model()->findByPk($this->objectId)->getModel();
    $models = $model->findAll();
    foreach($models as $model) {
      $sql .= "INSERT IGNORE INTO `" .$this->tableName . "`(`".implode("`, `", $newListFields)."`)\n";
      $sql .= "VALUES(";
      foreach ($oldListFields as $i=>$field) {
        if ($model->$field == null || !$model->$field) {
          $sql .= 'NULL';
        } else {
          $sql .= "'" . $model->$field . "'";
        }

        if ($count != ($i+1)) {
          $sql .= ",";
        }
      }
      $sql .= ");\n";
    }
    return $sql;
  }

  private function getInsertAuthItems() {
    //da_auth_item
    $sql = "
    INSERT IGNORE INTO `da_auth_item`(`name`, `type`, `description`, `data`)
    VALUES('create_object_".$this->newObjectId."', 0, 'Операция создание экземпляра объекта ".$this->objectName."', 'N;'),
    ('edit_object_".$this->newObjectId."', 0, 'Операция редактирования экземпляра объекта ".$this->objectName."', 'N;'),
    ('delete_object_".$this->newObjectId."', 0, 'Операция удаления экземпляра объекта ".$this->objectName."', 'N;'),
    ('list_object_".$this->newObjectId."', 0, 'Просмотр списка данных объекта  ".$this->objectName."', 'N;');
    ";
    //da_auth_item_child
    $sql .= "\n";
    $sql .= "
    INSERT IGNORE INTO `da_auth_item_child`(`parent`, `child`)
    VALUES('dev','create_object_".$this->newObjectId."'),
    ('dev','edit_object_".$this->newObjectId."'),
    ('dev','delete_object_".$this->newObjectId."'),
    ('dev','list_object_".$this->newObjectId."');
    ";
    $sql .= "\n";
    return $sql;
  }
}