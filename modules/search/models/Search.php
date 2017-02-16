<?php

/**
 * Модель для таблицы "da_search_data".
 *
 * The followings are the available columns in table 'da_search_data':
 * @property integer $id_object
 * @property integer $id_instance
 * @property integer $id_lang
 * @property string $value
 */
class Search extends CActiveRecord {

	public $model = null;
	public $link = null;
	public $title = null;
	
	public function getContent() {
		return $this->value;
	}
	
  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return Search the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'da_search_data';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
      array('id_object, id_instance, id_lang, value', 'required'),
      array('id_instance, id_lang', 'numerical', 'integerOnly'=>true),
      array('id_object', 'length', 'max' => 255),
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
      'id_object' => 'Id Object',
      'id_instance' => 'Id Instance',
      'id_lang' => 'Id Lang',
      'value' => 'Value',
    );
  }

}