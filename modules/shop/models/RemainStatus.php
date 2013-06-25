<?php

/**
 * This is the model class for table "pr_remain_status".
 *
 * The followings are the available columns in table 'pr_remain_status':
 * @property integer $id_remain_status
 * @property string $name
 * @property integer $min_value
 * @property integer $max_value
 */
class RemainStatus extends DaActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RemainStatus the static model class
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
		return 'pr_remain_status';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, min_value, max_value', 'required'),
			array('min_value, max_value', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_remain_status, name, min_value, max_value', 'safe', 'on'=>'search'),
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
			'id_remain_status' => 'Id Remain Status',
			'name' => 'Name',
			'min_value' => 'Min Value',
			'max_value' => 'Max Value',
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

		$criteria->compare('id_remain_status',$this->id_remain_status);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('min_value',$this->min_value);
		$criteria->compare('max_value',$this->max_value);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}