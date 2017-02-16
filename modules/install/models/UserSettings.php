<?php
class UserSettings extends CFormModel {
  public $name;
  public $fullName;
  public $email;
  public $passwordRepeat;
  public $password;
  
  public function rules() {
    return array(
      array('fullName, name, email, password, passwordRepeat', 'required'),
      array('email', 'email'),
      array('password', 'length', 'min' => '6'),
      array('password', 'compare', 'compareAttribute' => 'passwordRepeat'),
    );
  }
  public function attributeLabels() {
    return array(
      'fullName' => 'Ф.И.О.',
      'name' => 'Логин',
      'email' => 'E-mail',
      'password' => 'Пароль',
      'passwordRepeat' => 'Повторите пароль',
    );
  }
}