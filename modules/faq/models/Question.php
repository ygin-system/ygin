<?php

/**
 * This is the model class for table "{{question}}".
 *
 * The followings are the available columns in table '{{question}}':
 * @property integer $id_question
 * @property string $name
 * @property string $email
 * @property string $date
 * @property string $question
 * @property string $answer
 * @property integer $visible
 * @property integer $category
 */
class Question extends DaActiveRecord {
  const CATEGORY_GENERAL = 1;
  const CATEGORY_PERSONAL = 2;
  const ID_OBJECT = 512;
  const ID_EVENT_TYPE = 502;
  const ID_EVENT_SUBSCRIBER = 104;

  protected $idObject = self::ID_OBJECT;

	// Проверочный код
	public $verifyCode;

  public function init() {
    parent::init();
    $this->ask_date = time();
    $this->ip = HU::getUserIp();
  }

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Question the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'pr_question';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array_merge(array(
  		array('name, question, email', 'required'),
  		array('email', 'email'),
  		array('visible', 'numerical', 'integerOnly' => true),
  		array('name, email', 'length', 'max' => 255),
  		array('ask_date', 'length', 'max' => 10),
      array('category', 'in', 'range' => array_keys(self::categoriesList()), 'allowEmpty' => false),
  		array('answer', 'safe'),
		), Yii::app()->user->isGuest
		     ?  array(
		          array('verifyCode', 'required'),
		          array('verifyCode', 'captcha'),
		        )
		    : array()
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
            'id_question' => 'Id Question',
            'name' => 'Как Вас зовут',
            'email' => 'Ваш email',
            'ask_date' => 'Date',
            'question' => 'Текст сообщения',
            'answer' => 'Ответ',
            'visible' => 'Visible',
            'verifyCode' => 'Код проверки',
            'category' => 'Категория',
		);
	}

   public static function categoriesList() {
		return array(
			self::CATEGORY_GENERAL => 'Общие',
			self::CATEGORY_PERSONAL => 'Личные',
		);
	}

   public function getBackendEventHandler() {
    return array(
      'class' => 'faq.backend.FaqEventHandler'
    );
  }

  public function beforeValidate() {
    if ($this->send == 1 && $this->answer == null) {
      $this->addError('answer', 'Чтобы отправить ответ заполните его.');

      return false;
    }
    return true;
  }
}