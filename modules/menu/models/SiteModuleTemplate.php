<?php

/**
 * Модель для таблицы "da_site_module_template".
 *
 * The followings are the available columns in table 'da_site_module_template':
 * @property integer $id_module_template
 * @property string $name
 * @property integer $is_default_template
 */
class SiteModuleTemplate extends DaActiveRecord {
  
  const ID_OBJECT = 101;

  protected $idObject = self::ID_OBJECT;
  
  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return SiteModuleTemplate the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'da_site_module_template';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
      array('name', 'required'),
      array('is_default_template', 'numerical', 'integerOnly'=>true),
      array('name', 'length', 'max'=>255),

    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    return array(
      'modulePlaces' => array(self::HAS_MANY, 'SiteModulePlace', 'id_module_template', 'order' => 'modulePlaces.sequence'),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
      'id_module_template' => 'Id Module Template',
      'name' => 'Name',
      'is_default_template' => 'Is Default Template',
    );
  }

  public static function getIdDefaultTemplate() {
  	$connection = Yii::app()->db;
  	$command = $connection->createCommand("SELECT id_module_template FROM da_site_module_template WHERE is_default_template=1");
  	return $command->queryScalar();
  }
  
}