<?php

/**
 * Модель для таблицы "da_file_extension".
 *
 * The followings are the available columns in table 'da_file_extension':
 * @property integer $id_file_extension
 * @property string $ext
 * @property integer $id_file_type
 *
 * The followings are the available model relations:
 * @property FileType $fileType
 */
class FileExtension extends DaActiveRecord
 {

  const ID_OBJECT = 40;

  protected $idObject = self::ID_OBJECT;

  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return FileExtension the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'da_file_extension';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
      array('id_file_extension, ext', 'required'),
      array('id_file_extension, id_file_type', 'numerical', 'integerOnly'=>true),
      array('ext', 'length', 'max'=>20),

    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    return array(
      'fileType' => array(self::BELONGS_TO, 'FileType', 'id_file_type'),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
      'id_file_extension' => 'ID',
      'ext' => 'Расширение',
      'id_file_type' => 'Тип файла',
    );
  }
  public static function getTypeByExt($ext) {
    foreach (self::getModels() as $model) {
      if (mb_strtolower($ext) == $model->ext) {
        return $model->id_file_type;
      }
    }
    return null;
  }
  public static function getExtensionsByType($type) {
    $result = array();
    foreach(self::getModels() as $model) {
      if ($model->id_file_type == $type) {
        $result[] = $model->ext;
      }
    }
    return $result;
  }
  protected static function getModels() {
    return self::model()->cache(10000)->findAll();
  }

}