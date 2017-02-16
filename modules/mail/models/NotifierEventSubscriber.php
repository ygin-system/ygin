<?php

/**
 * This is the model class for table "da_event_subscriber".
 *
 * The followings are the available columns in table 'da_event_subscriber':
 * @property integer $id_event_subscriber
 * @property integer $id_event_type
 * @property integer $id_user
 * @property integer $format
 * @property integer $archive_attach
 * @property string $email
 * @property string $name
 */
class NotifierEventSubscriber extends DaActiveRecord {
  
  const ID_OBJECT = 34;
  protected $idObject = self::ID_OBJECT;

  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return NotifierEventSubscriber the static model class
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
    return 'da_event_subscriber';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules()
  {
    return array(
      array('format', 'required'),
      array('id_event_type, id_user, format, archive_attach', 'numerical', 'integerOnly'=>true),
      array('email', 'length', 'max'=>60),
      array('name', 'length', 'max'=>255),
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations()
  {
    return array(
      'eventFormat' => array(self::BELONGS_TO, 'NotifierEventFormat', 'format', 'joinType' => 'INNER JOIN'),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels()
  {
    return array(
      'id_event_subscriber' => 'Id Event Subscriber',
      'id_event_type' => 'Id Event Type',
      'id_user' => 'Id User',
      'format' => 'Format',
      'archive_attach' => 'Archive Attach',
      'email' => 'Email',
      'name' => 'Name',
    );
  }
  
  public function getIsArchiveAttachment() {
    return (bool)$this->archive_attach;
  }
}