<?php

/**
 * This is the model class for table "da_event_format".
 *
 * The followings are the available columns in table 'da_event_format':
 * @property integer $id_event_format
 * @property string $description
 * @property integer $place
 * @property string $file_name
 * @property string $name
 */
class NotifierEventFormat extends DaActiveRecord {
  /**
   * Содержимое сообщения находится в теле письма
   * @var int
   */
  const PLACE_TEXT = 1;
	/**
	 * Содержимое сообщения находится в во вложении
	 * @var int
	 */
	const PLACE_ATTACHMENT = 2;
	/**
	 * Тип сообщения - text/plain
	 * @var string
	 */
	const TYPE_PLAIN_TEXT = 'TXT';
	/**
	 * Тип сообщения - text/html
	 * @var string
	 */
	const TYPE_HTML = 'HTML';
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return NotifierEventFormat the static model class
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
		return 'da_event_format';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('description, name', 'required'),
			array('place', 'numerical', 'integerOnly'=>true),
			array('description', 'length', 'max'=>255),
			array('file_name', 'length', 'max'=>50),
			array('name', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_event_format, description, place, file_name, name', 'safe', 'on'=>'search'),
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
			'id_event_format' => 'Id Event Format',
			'description' => 'Description',
			'place' => 'Place',
			'file_name' => 'File Name',
			'name' => 'Name',
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

		$criteria->compare('id_event_format',$this->id_event_format);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('place',$this->place);
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}