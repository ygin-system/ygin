<?php

/**
 * Модель для таблицы "da_file_upload_settings".
 *
 * The followings are the available columns in table 'da_file_upload_settings':
 * @property integer $id_file_settings
 * @property integer $id_object
 * @property integer $id_parameter
 * @property integer $id_add_object
 * @property integer $countFiles
 * @property integer $id_file_type
 * @property string $minSizeLimit
 * @property string $sizeLimit
 *
 * The followings are the available model relations:
 * @property Object $object
 * @property ObjectParameter $parameter
 * @property Object $addObject
 * @property FileType $fileType
 */
class FileUploadSettings extends DaActiveRecord
 {

  const ID_OBJECT = 93;

  protected $idObject = self::ID_OBJECT;

  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return FileUploadSettings the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'da_file_upload_settings';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
      array('id_file_settings, id_object, id_parameter', 'required'),
      array('id_file_settings, id_object, id_parameter, id_add_object, countFiles, id_file_type', 'numerical', 'integerOnly'=>true),
      array('minSizeLimit, sizeLimit', 'length', 'max'=>255),

    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    return array(
      'object' => array(self::BELONGS_TO, 'Object', 'id_object'),
      'parameter' => array(self::BELONGS_TO, 'ObjectParameter', 'id_parameter'),
      'addObject' => array(self::BELONGS_TO, 'Object', 'id_add_object'),
      'fileType' => array(self::BELONGS_TO, 'FileType', 'id_file_type'),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
      'id_file_settings' => 'ID',
      'id_object' => 'Объект',
      'id_parameter' => 'Свойство объекта',
      'id_add_object' => 'Дополнительный параметр',
      'countFiles' => 'Максимальное количество загруженных файлов',
      'id_file_type' => 'Тип файла',
      'minSizeLimit' => 'Минимально разрешённый размер загружаемых файлов (в байтах)',
      'sizeLimit' => 'Максимально разрешённый размер загружаемых файлов (в байтах)',
    );
  }

}