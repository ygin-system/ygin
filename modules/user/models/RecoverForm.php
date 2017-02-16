<?php
class RecoverForm extends BaseFormModel {
  private $_userModel;
  private $_newPassword;
  public $login;
  
  public function getUserModel() {
    return $this->_userModel;
  }
  public function getNewPassword() {
    return $this->_newPassword;
  }
  
  public function rules() {
    return array(
      array('login', 'required'),
      array('login', 'findUser'),
    );
  }
  
  public function findUser($attribute, $params) {
    $criteria = new CDbCriteria();
    //если в качестве логина указали email
    $criteria->params = array(':LOGIN' => mb_strtolower($this->login));
    if (($isEmail = mb_stripos($this->login, '@')) !== false) {
      $criteria->addCondition('LOWER(mail)=:LOGIN');
    } else {
      $criteria->addCondition('LOWER(name)=:LOGIN');
    }
    $model = User::model()->find($criteria);
    if ($model === null) {
      if ($isEmail) {
        $this->addError($attribute, 'Пользователь с таким e-mail не существует.');
      } else {
        $this->addError($attribute, 'Пользователь с таким логином не существует.');
      }
    } else {
      $this->_userModel = $model;
    }
  }
  
  public function onRecover(CEvent $event) {
    $this->raiseEvent('onRecover', $event);
  }
  
  public function recover() {
    $this->_newPassword = HText::getRandomString(8);
    $this->_userModel->user_password = $this->_newPassword; //$this->_userModel->hashPassword($this->_newPassword);
    $this->_userModel->save();
    if ($this->hasEvent('onRecover')) {
      $this->onRecover(new CEvent($this));
    }
  }
  
  public function attributeLabels() {
    return array(
      'login' => 'Логин или e-mail',
    );
  }
}