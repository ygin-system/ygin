<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends BaseFormModel {

  public $username;
  public $password;
  public $rememberMe;
	public $verifyCode;
  private $_identity;

  public function rules() {
    $rules = array(
        // username and password are required
        array('username, password', 'required'),
        // rememberMe needs to be a boolean
        array('rememberMe', 'boolean'),
        // password needs to be authenticated
        array('password', 'authenticate'),
    );
    if (isset(Yii::app ()->request->cookies[ 'login_attempt' ]) && Yii::app ()->request->cookies[ 'login_attempt' ]->value >= 3) {
      $rules = CMap::mergeArray($rules, array(
        array('verifyCode', 'DaCaptchaValidator', 'caseSensitive' => true)
      ));
    }
    return $rules;
  }

  /**
   * Declares attribute labels.
   */
  public function attributeLabels() {
    return array(
        'rememberMe' => 'Запомнить меня',
        'username' => 'Логин',
        'password' => 'Пароль',
    );
  }

  /**
   * Authenticates the password.
   * This is the 'authenticate' validator as declared in rules().
   */
  public function authenticate($attribute, $params) {
    if (!$this->hasErrors()) {
      $this->_identity = new UserIdentity($this->username, $this->password);
      if (!$this->_identity->authenticate()) {
        if ($this->_identity->errorCode == UserIdentity::ERROR_USER_BLOCKED) {
          $this->addError('username', 'Пользователь заблокирован.');
        } else {
          $this->addError('password', 'Неверное имя пользователя или пароль.');
        }
      }
    }
  }

  /**
   * Logs in the user using the given username and password in the model.
   * @return boolean whether login is successful
   */
  public function login() {
    if ($this->_identity === null) {
      $this->_identity = new UserIdentity($this->username, $this->password);
      $this->_identity->authenticate();
    }
    if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
      $duration = 0;
      if ($this->rememberMe && Yii::app()->user->remeberAvailable) {
        $duration = Yii::app()->user->durationIfRemeber == 0 ? 720 : Yii::app()->user->durationIfRemeber;
        $duration = $duration * 3600; // часы->секунды
      }
      return Yii::app()->user->login($this->_identity, $duration);
    }
    return false;
  }

}
