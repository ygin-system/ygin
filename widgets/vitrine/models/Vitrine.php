<?php

/**
 * Модель для таблицы "pr_vitrine".
 *
 * The followings are the available columns in table 'pr_vitrine':
 * @property integer $id_vitrine
 * @property string $link
 * @property string $title
 * @property string $text
 * @property integer $image
 * @property integer $sequence
 */
class Vitrine extends DaActiveRecord
 {
  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return Vitrine the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'pr_vitrine';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
      array('id_vitrine', 'required'),
      array('id_vitrine, image, sequence', 'numerical', 'integerOnly'=>true),
      array('link, title', 'length', 'max'=>255),
      array('text', 'safe'),

    );
  }
  
  public function defaultScope() {
  	return array(
      'order' => 'sequence ASC',
  	  'with' => 'file',
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    return array(
      'file' => array(self::HAS_ONE, 'File', array('id_file' => 'image'), 'joinType' => 'LEFT JOIN', 'select' => 'id_file, file_path, id_object, id_instance, id_parameter, id_property'),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
      'id_vitrine' => 'Id vitrine',
      'link' => 'Link',
      'title' => 'Title',
      'text' => 'Text',
      'image' => 'Image',
      'sequence' => 'Sequence',
    );
  }

}