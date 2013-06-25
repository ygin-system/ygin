<?php

/**
 * Модель для таблицы "pr_client_review".
 *
 * The followings are the available columns in table 'pr_client_review':
 * @property integer $id_client_review
 * @property string $name
 * @property integer $create_date
 * @property string $review
 * @property string $ip
 * @property integer $visible
 * @property string $contact
 */
class Review extends DaActiveRecord {
  
  // Проверочный код
  public $verifyCode;

  public function init() {
    parent::init();
    if ($this->isNewRecord) {
      $this->create_date = time();
      $this->ip = HU::getUserIp();
    }
  }
  
  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return Review the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'pr_client_review';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array_merge(array(
        array('name, review', 'required'),
        array('visible', 'numerical', 'integerOnly' => true),
        array('name, ip, contact', 'length', 'max' => 255),
        array('review', 'safe'),
      ), Yii::app()->user->isGuest ? array(
           array('verifyCode', 'required'),
           array('verifyCode', 'captcha'),
         ) : array()
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
      'id_client_review' => 'Id Client Review',
      'name' => 'Имя',
      'create_date' => 'Дата',
      'review' => 'Отзыв',
      'ip' => 'Ip',
      'visible' => 'Visible',
      'contact' => 'Контактная информация',
      'verifyCode' => 'Код проверки',
    );
  }

}