<?php

/**
 * This is the model class for table "da_event_type".
 *
 * The followings are the available columns in table 'da_event_type':
 * @property integer $id_event_type
 * @property integer $id_object
 * @property integer $last_time
 * @property integer $interval_value
 * @property string $sql_condition
 * @property string $name
 * @property string $condition_done
 * @property integer $id_mail_account
 */
class NotifierEventType extends DaActiveRecord {
  
  const ID_OBJECT = 35;
  protected $idObject = self::ID_OBJECT;

  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return NotifierEventType the static model class
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
    return 'da_event_type';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
      array('name', 'required'),
      array('last_time, interval_value, id_mail_account', 'numerical', 'integerOnly'=>true),
      array('id_object, sql_condition, condition_done', 'length', 'max'=>255),
      array('name', 'length', 'max'=>100),
      array('id_event_type', 'unsafe'),
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    return array(
      'mailAccount' => array(self::BELONGS_TO, 'NotifierMailAccount', 'id_mail_account', 'joinType' => 'INNER JOIN'),
      'subscribers' => array(self::HAS_MANY, 'NotifierEventSubscriber', 'id_event_type'),
      'events' => array(self::HAS_MANY, 'NotifierEvent', 'id_event_type'),
    );
  }

    public function behaviors() {
      return array(
        'CascadeDelete' => array(
          'class' => 'CascadeDeleteBehavior',
          'relations' => array(
            'events',
            'subscribers',
          ),
        ),
      );
    }    
    
  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels()
  {
    return array(
      'id_event_type' => 'Id Event Type',
      'id_object' => 'Id Object',
      'last_time' => 'Last Time',
      'interval_value' => 'Interval Value',
      'sql_condition' => 'Sql Condition',
      'name' => 'Name',
      'condition_done' => 'Condition Done',
      'id_mail_account' => 'Id Mail Account',
    );
  }

  public function getSelectQuery() {
    return $this->sql_condition;
  }
  
  public function getDoneQuery() {
    return $this->condition_done;
  }
  
  public function getTimeoutIsExpired() {
    if ($this->interval_value == null || $this->last_time == null) {
      return true;
    }
    return $this->last_time + $this->interval_value < time();
  }
  
  public function updateLastTime() {
    $this->last_time = time();
    $this->update(array('last_time'));
  }
}