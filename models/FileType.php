<?php

/**
 * Модель для таблицы "da_file_type".
 *
 * The followings are the available columns in table 'da_file_type':
 * @property integer $id_file_type
 * @property string $name
 *
 * The followings are the available model relations:
 * @property Files[] $files
 * @property FileExtension[] $fileExtensions
 * @property FileUploadSettings[] $fileUploadSettings
 */
class FileType extends DaActiveRecord
 {

  const ID_OBJECT = 39;

  protected $idObject = self::ID_OBJECT;

  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return FileType the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'da_file_type';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
      array('id_file_type, name', 'required'),
      array('id_file_type', 'numerical', 'integerOnly'=>true),
      array('name', 'length', 'max'=>255),

    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    return array(
      'files' => array(self::HAS_MANY, 'Files', 'id_file_type'),
      'fileExtensions' => array(self::HAS_MANY, 'FileExtension', 'id_file_type'),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
      'id_file_type' => 'ID',
      'name' => 'Название',
    );
  }

}