<?php

/**
 * This is the model class for table "da_system_parameter".
 *
 * The followings are the available columns in table 'da_system_parameter':
 * @property integer $id_system_parameter
 * @property integer $id_group_system_parameter
 * @property string $name
 * @property string $value
 * @property string $note
 * @property integer $id_parameter_type
 * @property string $long_text_value
 */
class SystemParameter extends DaActiveRecord {

  const ID_OBJECT = 30;
  protected $idObject = self::ID_OBJECT;

  const TYPE_INT = 1;
  const TYPE_VARCHAR = 2;
  const TYPE_BLOB = 3;
  const TYPE_TIMESTAMP = 4;
  const TYPE_REFERENCE = 6;
  const TYPE_OBJECT = 7;
  const TYPE_FILE = 8;
  const TYPE_BOOLEAN = 9;
  const TYPE_TEXTAREA = 14;

  const GROUP_SYSTEM = 1;
  const GROUP_SITE= 2;
  
  
  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return SystemParameter the static model class
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName()
  {
    return 'da_system_parameter';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules()
  {
    return array(
      array('name', 'required'),
      array('id_group_system_parameter, id_parameter_type', 'numerical', 'integerOnly'=>true),
      array('name', 'length', 'max'=>60),
      array('id_system_parameter, value, note', 'length', 'max'=>255),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels()
  {
    return array(
      'id_system_parameter' => 'Id System Parameter',
      'id_group_system_parameter' => 'Id Group System Parameter',
      'name' => 'Name',
      'value' => 'Value',
      'note' => 'Note',
      'id_parameter_type' => 'Id Parameter Type',
    );
  }

  public function getTypedValue($default = null) {
    $value = null;
    switch ((int)$this->id_parameter_type) {
      case self::TYPE_INT:
      case self::TYPE_TIMESTAMP:
      case self::TYPE_BOOLEAN:
      case self::TYPE_VARCHAR:
        $value = $this->value;
        break;
      case self::TYPE_BLOB:
      case self::TYPE_TEXTAREA:
        $value = $this->long_text_value;
        break;
      default:
        $value = $this->value;
    }
    
    if ($value === null) {
      return $default;
    }
    
    switch ((int)$this->id_parameter_type) {
      case self::TYPE_INT:
      case self::TYPE_TIMESTAMP:
        return (int)$value;
      case self::TYPE_BOOLEAN:
        return (bool)$value;
      case self::TYPE_BLOB:
      case self::TYPE_TEXTAREA:
      case self::TYPE_VARCHAR:
        return $value;
    }
  }

  public function getBackendEventHandler() {
    return array(
      'class' => 'backend.backend.SystemParameterEventHandler'
    );
  }
}