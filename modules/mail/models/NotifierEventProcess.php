<?php

/**
 * This is the model class for table "da_event_process".
 *
 * The followings are the available columns in table 'da_event_process':
 * @property integer $id_event
 * @property string $email
 * @property integer $notify_date
 * @property integer $id_event_subscriber
 */
class NotifierEventProcess extends BaseActiveRecord {
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return NotifierEventProcess the static model class
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
		return 'da_event_process';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email', 'required'),
			array('id_event, notify_date, id_event_subscriber', 'numerical', 'integerOnly'=>true),
			array('email', 'length', 'max'=>70),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		  'notifierEvent' => array(self::BELONGS_TO, 'NotifierEvent', 'id_event', 'joinType' => 'INNER JOIN'),
		  'eventSubscriber' => array(self::BELONGS_TO, 'NotifierEventSubscriber', 'id_event_subscriber',
		                             'joinType' => 'INNER JOIN'),
		);
	}
	
	public function scopes() {
	  $a = $this->tableAlias;
	  return array(
	    'scForSend' => array(
	      'condition' => $a.'.notify_date IS NULL',
	      'with' => array(
	        'eventSubscriber',
	        'eventSubscriber.eventFormat',
	        'notifierEvent',
	        'notifierEvent.eventType' => array('select' => 'eventType.name, eventType.id_event_type, eventType.id_mail_account'),
	        'notifierEvent.eventType.mailAccount',
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
			'id_event' => 'Id Event',
			'email' => 'Email',
			'notify_date' => 'Notify Date',
			'id_event_subscriber' => 'Id Event Subscriber',
		);
	}
	
	public function saveAsSent($time = null) {
	  $this->notify_date = $time ? $time : time();
	  $this->update();
	}
}