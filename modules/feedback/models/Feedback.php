<?php

/**
 * This is the model class for table "pr_feedback".
 *
 * The followings are the available columns in table 'pr_feedback':
 * @property integer $id_feedback
 * @property string $fio
 * @property string $phone
 * @property string $mail
 * @property string $message
 * @property integer $date
 * @property string $ip
 * @property integer $is_send
 */
class Feedback extends DaActiveRecord {

  const ID_OBJECT = 517;
  protected $idObject = self::ID_OBJECT;

  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return Feedback the static model class
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }
  
  public $verifyCode;
   
  public function init() {
    parent::init();
    $this->date = time();
    $this->ip = HU::getUserIp();
  }

  /**
   * @return string the associated database table name
   */
  public function tableName()
  {
    return 'pr_feedback';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
      array('fio, message', 'required'),
      array('mail', 'email', 'message' => 'Введен некорректный e-mail адрес'),
      array('verifyCode', 'DaCaptchaValidator', 'caseSensitive' => true),
      array('fio, phone, mail', 'length', 'max'=>255),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels()
  {
    return array(
      'id_feedback' => 'Id Feedback',
      'fio' => 'Представьтесь',
      'phone' => 'Телефон',
      'mail' => 'e-mail',
      'message' => 'Сообщение',
      'date' => 'Дата',
      'ip' => 'Ip',
      'verifyCode' => 'Код проверки'
    );
  }

}