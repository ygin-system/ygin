<?php

/**
 * This is the model class for table "da_mail_account".
 *
 * The followings are the available columns in table 'da_mail_account':
 * @property integer $id_mail_account
 * @property string $email_from
 * @property string $from_name
 * @property string $default_subject
 * @property string $host
 * @property string $user_name
 * @property string $user_password
 * @property integer $smtp_auth
 */
class NotifierMailAccount extends DaActiveRecord
{
	const ID_OBJECT = 50;
	
	protected $idObject = self::ID_OBJECT;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return NotifierMailAccount the static model class
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
		return 'da_mail_account';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('host', 'required'),
			array('smtp_auth', 'numerical', 'integerOnly'=>true),
			array('email_from, host, user_name, user_password', 'length', 'max'=>50),
			array('from_name', 'length', 'max'=>100),
			array('default_subject', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('email_from, from_name, default_subject, host, user_name, user_password, smtp_auth', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_mail_account' => 'Id Mail Account',
			'email_from' => 'Email From',
			'from_name' => 'From Name',
			'default_subject' => 'Default Subject',
			'host' => 'Host',
			'user_name' => 'User Name',
			'user_password' => 'User Password',
			'smtp_auth' => 'Smtp Auth',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_mail_account',$this->id_mail_account);
		$criteria->compare('email_from',$this->email_from,true);
		$criteria->compare('from_name',$this->from_name,true);
		$criteria->compare('default_subject',$this->default_subject,true);
		$criteria->compare('host',$this->host,true);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('user_password',$this->user_password,true);
		$criteria->compare('smtp_auth',$this->smtp_auth);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getIsNeedAuthorize() {
	  return (bool)$this->smtp_auth;
	}
}