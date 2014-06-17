<?php
class DbSettings extends CFormModel {
  public $host;
  public $dbname;
  public $user;
  public $password;
  public $port;
  public $createDb = 0;
  private $dbc;
  
  public function rules() {
    return array(
      array('host, dbname, user', 'required'),
      array('host, dbname, user, password', 'length', 'max' => 255),
      array('port', 'numerical'),
      array('createDb', 'boolean'),
    );
  }

  /**
   * @return CDbConnection
   */
  public function getDbConnection() {
    if ($this->dbc === null) {
      $this->dbc = Yii::createComponent(array(
        'class' => 'CDbConnection',
        'connectionString' => $this->getConnectionString(),
        'username' => $this->user,
        'password' => $this->password,
        'charset' => 'utf8',
      ));
    }
    return $this->dbc;
  }
  
  public function __sleep() {
    $this->dbc = null;
    return array_keys(get_object_vars($this));
  }
  
  protected function afterValidate() {
    $dbConnection = $this->getDbConnection();
    try {
      $dbConnection->active = true;
    } catch (CDbException $e) {
      $this->addError(
        'dbname',
        'Не удалось подключиться к базе данных. Ошибка: "'. $e->getMessage() . '"'
      );
    }
    return parent::afterValidate();
  }
  public function getConnectionString() {
    $dsn = 'mysql:host='.$this->host;
    if (!$this->createDb) {
      $dsn .= ';dbname='.$this->dbname;
    }
    if ($this->port) {
      $dsn .= ';port='.$this->port;
    }
    return $dsn;
  }
  public function attributeLabels() {
    return array(
      'host' => 'Хост',
      'dbname' => 'База данных',
      'user' => 'Пользователь (логин)',
      'password' => 'Пароль',
      'port' => 'Порт',
      'createDb' => 'Создать базу',
    );
  }
  public function createDb() {
    $db = $this->getDbConnection();
    $db->createCommand('
      CREATE DATABASE IF NOT EXISTS `'.$this->dbname.'` COLLATE utf8_general_ci
    ')->execute();
    $db->createCommand('USE `'.$this->dbname.'`')->execute();
  }
}