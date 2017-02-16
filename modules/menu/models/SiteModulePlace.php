<?php

/**
 * Модель для таблицы "da_site_module_rel".
 *
 * The followings are the available columns in table 'da_site_module_rel':
 * @property integer $id_module
 * @property integer $place
 * @property integer $sequence
 * @property integer $id_module_template
 */
class SiteModulePlace extends BaseActiveRecord {
	
  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return SiteModulePlace the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }
  
	public function primaryKey() {
	  return array('id_module_template', 'id_module');
	}

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'da_site_module_rel';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
      array('id_module_template', 'required'),
      array('id_module, place, sequence, id_module_template', 'numerical', 'integerOnly'=>true),

    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    return array(
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
      'id_module' => 'Id Module',
      'place' => 'Place',
      'sequence' => 'Sequence',
      'id_module_template' => 'Id Module Template',
    );
  }

}