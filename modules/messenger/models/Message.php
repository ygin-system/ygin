<?php

/**
 * Модель для таблицы "da_message".
 *
 * The followings are the available columns in table 'da_message':
 * @property integer $id_message
 * @property string $text
 * @property string $date
 * @property integer $type
 * @property string $sender
 */
class Message extends DaActiveRecord {
  
  const TYPE_INFO    = 1;
  const TYPE_SUCCESS = 2;
  const TYPE_ERROR   = 3;
  
  const ID_OBJECT = 531;

  protected $idObject = self::ID_OBJECT;

  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return Message the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'da_message';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
      array('text, date', 'required'),
      array('type', 'numerical', 'integerOnly'=>true),
      array('date', 'length', 'max'=>10),

    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    return array(
      'users' => array(self::MANY_MANY, 'User', 'da_link_message_user(id_message, id_user)'),
    );
  }
  
  public function unread($idUser, $expiredInterval) {
    $a = $this->tableAlias;
    $this->dbCriteria->mergeWith(array(
      'join' => "LEFT OUTER JOIN (
                  `da_link_message_user` `users_users`
                  JOIN `da_users` `users` ON (`users`.`id_user`=`users_users`.`id_user`)  AND (`users`.`id_user`=:ID_U)
                ) ON (`t`.`id_message`=`users_users`.`id_message`)",
      'condition' => "users.id_user IS NULL AND $a.date > :TIME",
      'params' => array(':TIME' => time() - $expiredInterval, ':ID_U' => $idUser),
    ));
    return $this;
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
      'id_message' => 'Id Message',
      'text' => 'Text',
      'date' => 'Date',
      'type' => 'Type',
    	'sender' => 'Sender',
    );
  }
  
  public function markAsRead($idUser) {
    $this->dbConnection
      ->createCommand('INSERT IGNORE INTO `da_link_message_user`(`id_message`, `id_user`) VALUES(:IDM, :IDU)')
      ->execute(array(':IDM' => $this->primaryKey, ':IDU' => $idUser));
    return true;
  }

}
