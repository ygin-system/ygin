<?php

/**
 * This is the model class for table "pr_link_offer_product".
 *
 * The followings are the available columns in table 'pr_link_offer_product':
 * @property integer $id_offer
 * @property integer $id_product
 * @property integer $amount
 */
class OfferProduct extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LinkOfferProduct the static model class
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
		return 'pr_link_offer_product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('id_offer, id_product, amount', 'required'),
			array('id_offer, id_product, amount', 'numerical', 'integerOnly'=>true),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
		  'product' => array(self::BELONGS_TO, 'Product', 'id_product'),
		  'offer' => array(self::BELONGS_TO, 'Offer', 'id_offer'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_offer' => 'Id Offer',
			'id_product' => 'Id Product',
			'amount' => 'Amount',
		);
	}
}