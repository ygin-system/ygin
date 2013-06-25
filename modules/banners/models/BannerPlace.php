<?php

/**
 * This is the model class for table "pr_banner_place".
 *
 * The followings are the available columns in table 'pr_banner_place':
 * @property integer $id_banner_place
 * @property integer $id_object
 * @property integer $id_instance
 * @property string $title
 * @property integer $showing
 * @property integer $sequence
 * @property integer $id_parent
 */
class BannerPlace extends DaActiveRecord {

  const CLICK_DAY = 1;
  const CLICK_MONTH = 2;
  const CLICK_ALL = 3;
  const VIEWING_TYPE_DAY = 4;
  const VIEWING_TYPE_MONTH = 5;
  const VIEWING_TYPE_ALL = 6;

  /**
   * Вывод баннеров поочередно в заданом порядке
   * @var int
   */
  const ST_BY_ORDER = 1; 
  /**
   * Вывод баннеров в произвольном порядке
   * @var int
   */
  const ST_RANDOM = 2;
  /**
   * Вывод всех баннеров
   * @var int
   */
  const ST_ALL = 3;
	
  const ID_OBJECT = 261;
  protected $idObject = self::ID_OBJECT;

  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return BannerPlace the static model class
   */
  public static function model($className = __CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'pr_banner_place';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
        array('title, showing', 'required'),
        array('id_object, id_instance, showing, sequence, id_parent', 'numerical', 'integerOnly' => true),
        array('title', 'length', 'max' => 255),
        array('id_banner_place', 'unsafe'),
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    return array(
        'banners' => array(self::HAS_MANY, 'Banner', 'id_banner_place', 'joinType' => 'INNER JOIN'),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
        'id_banner_place' => 'Id Banner Place',
        'id_object' => 'Id Object',
        'id_instance' => 'Id Instance',
        'title' => 'Title',
        'showing' => 'Showing',
        'sequence' => 'Sequence',
        'id_parent' => 'Id Parent',
    );
  }

  public function getBackendEventHandler() {
    return array(
      'class' => 'banners.backend.BannerPlaceEventHandler',
    );
  }

}