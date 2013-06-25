<?php
class ExportObject extends CFormModel {
  public $objectId;
  public function rules() {
    return array(
      array('objectId', 'required'),
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
    return "INSERT INTO `".$tableName."`(`".implode("`, `", array_keys($populatedData))."`)\n".
           "VALUES (".implode(', ', $populatedData).");\n";
  }
  
  public function getDump() {
    $object = DaObject::model()->findByPk($this->objectId);
    $fields = ObjectParameter::model()->findAll('`id_object` = ?', array($this->objectId));
    $str = "START TRANSACTION;\n";
    $fieldNames = array(
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
    $str .= $this->getInsertStatement(
      'da_object', 
      $this->getPopulatedData($fieldNames, $object, array('id_field_caption' => 'NULL', 'id_field_order' => 'NULL')
    ));
    $str .= "SET @objectId = LAST_INSERT_ID();\n";
    
    $fieldNames = array(
      'id_object',
      'id_parameter_type',
      'sequence',
      'name',
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
    foreach ($fields as $field) {
      $str .= $this->getInsertStatement(
        'da_object_parameters',
        $this->getPopulatedData($fieldNames, $field, array('id_object' => '@objectId')
      ));
      if ($field->id_parameter == $object->id_field_order) {
        $str .= "UPDATE `da_object` SET `id_field_order` = LAST_INSERT_ID() WHERE `id_object` = @objectId;\n";
      } elseif ($field->id_parameter == $object->id_field_caption) {
        $str .= "UPDATE `da_object` SET `id_field_caption` = LAST_INSERT_ID() WHERE `id_object` = @objectId;\n";
      }
    }
    $str .= 'COMMIT;';
    return $str;
  }
}