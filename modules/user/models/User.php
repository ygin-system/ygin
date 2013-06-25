<?php

/**
 * This is the model class for table "da_users".
 *
 * The followings are the available columns in table 'da_users':
 * @property integer $id_user
 * @property string $name
 * @property string $user_password
 * @property string $mail
 * @property string $full_name
 * @property string $rid
 * @property integer $create_date
 * @property integer $count_post
 * @property integer $active
 * @property string $salt
 * @property integer $requires_new_password
 * @property string $password_strategy
 */
class User extends DaActiveRecord {
  
  const ID_OBJECT = 24;
  /**
   * @var int Группа зарегистрированный пользователь
   */
  const GROUP_REGISTERED = 100;
  
  protected $idObject = self::ID_OBJECT;
  public $verifyCode;
  
  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return User the static model class
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
    return 'da_users';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
      array('name', 'unique'),
      array('name, user_password', 'required', 'on' => 'register, backendInsert'),
      array('verifyCode', 'required', 'on' => 'register'),
      array('mail', 'required', 'on' => 'register, profile, backendInsert, backendUpdate'),
      array('name', 'length', 'max' => 100, 'on' => 'register, backendInsert, backendUpdate'),
      array('name', 'unique', 'on' => 'register, backendInsert, backendUpdate'),
      array('mail', 'length', 'max'=>100),
      array('mail', 'email'),
      array('mail', 'unique', 'on' => 'register, backendInsert'),
      array('mail', 'unique', 'criteria'=>array('condition' => 'id_user <> '.$this->id_user), 'on' => 'profile, backendUpdate'),
      array('user_password', 'length', 'max'=>150, 'min' => 6),
      array('full_name', 'length', 'max'=>200),
      array('verifyCode', 'DaCaptchaValidator', 'caseSensitive' => true, 'on' => 'register'),
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
  public function attributeLabels()
  {
    return array(
      'id_user' => 'Id User',
      'name' => 'Логин',
      'user_password' => 'Пароль',
      'mail' => 'E-mail',
      'full_name' => 'Ф.И.О.',
      'rid' => 'Rid',
      'create_date' => 'Create Date',
      'count_post' => 'Count Post',
      'verifyCode' => 'Код проверки',
    );
  }
  
  public function behaviors() {
    return array(
      'CTimestampBehavior' => array(
        'class' => 'zii.behaviors.CTimestampBehavior',
        'createAttribute' => 'create_date',
        'updateAttribute' => null
      ),
      "APasswordBehavior" => array(
        "class" => "APasswordBehavior",
        "defaultStrategyName" => "sha1",
        "passwordAttribute" => "user_password",
        "strategies" => array(
          'sha1' => array(
            'class' => 'AHashPasswordStrategy',
          ),
          "bcrypt" => array(
            "class" => "DaBcryptPasswordStrategy",
            "workFactor" => 14
          ),
          "legacy" => array(
            "class" => "ALegacyMd5PasswordStrategy",
          )
        ),
      ),
    );
  }

  protected function beforeDelete() {
    $currentRoles = Yii::app()->authManager->getAuthItems(CAuthItem::TYPE_ROLE, $this->id_user);
    foreach($currentRoles AS $role) {
      Yii::app()->authManager->revoke($role->name, $this->id_user);
    }

    return parent::beforeDelete();
  }

  public function isActive() {
    return intval($this->active) === 1;
  }
  public function isBlocked() {
    return !$this->isActive();
  }
  
  public function validatePassword($password) {
    return $this->verifyPassword($password);
  }
  
  public function getEncodedName() {
    return CHtml::encode($this->name);
  }
  public function getDisplayName() {
    return $this->getEncodedName();
  }
  public function getBackendEventHandler() {
    return array(
      'class'=>'user.backend.UserEventHandler',
    );
  }

}