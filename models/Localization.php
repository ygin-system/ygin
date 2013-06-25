<?php

/**
 * Модель для таблицы "da_localization".
 *
 * The followings are the available columns in table 'da_localization':
 * @property integer $id_localization
 * @property string $name
 * @property string $code
 * @property integer $is_use
 */
class Localization extends DaActiveRecord {
	
	const LOCALE_MAIN = 1;
	
  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return Localization the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'da_localization';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
      array('name, code', 'required'),
      array('is_use', 'numerical', 'integerOnly'=>true),
      array('name', 'length', 'max'=>60),
      array('code', 'length', 'max'=>3),

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
      'id_localization' => 'Id Localization',
      'name' => 'Name',
      'code' => 'Code',
      'is_use' => 'Is Use',
    );
  }

}