<?php

/**
 * This is the model class for table "pr_news_category".
 *
 * The followings are the available columns in table 'pr_news_category':
 * @property integer $id_news_category
 * @property string $name
 * @property integer $seq
 * @property integer $is_visible
 */
class NewsCategory extends DaActiveRecord {

  const ID_OBJECT = 503;
  protected $idObject = self::ID_OBJECT;

  /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return NewsCategory the static model class
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
		return 'pr_news_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name', 'required'),
			array('seq, is_visible', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
		  'news' => array(self::HAS_MANY, 'News', 'id_news_category', 'joinType' => 'INNER JOIN'),
		  'newsCount' => array(self::STAT, 'News', 'id_news_category', 'condition' => 'is_visible = 1'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id_news_category' => 'Id News Category',
			'name' => 'Name',
			'seq' => 'Seq',
			'is_visible' => 'Is Visible',
		);
	}
	
	public function getUrl() {
	  return Yii::app()->createUrl(NewsModule::ROUTE_NEWS_CATEGORY, array('idCategory' => $this->id_news_category));
	}
}