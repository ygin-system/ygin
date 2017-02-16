<?php

/**
 * Модель для таблицы "pr_product".
 *
 * The followings are the available columns in table 'pr_product':
 * @property integer $id_product
 * @property integer $id_product_category
 * @property string $code
 * @property string $name
 * @property integer $trade_price
 * @property integer $sm_trade_price
 * @property integer $retail_price
 * @property string $unit
 * @property string $remain
 * @property string $description
 * @property integer $deleted
 * @property integer $image
 * @property integer $id_brand
 */
class Product extends DaActiveRecord implements ISearchable {
  
  const ID_OBJECT = 511;
  protected $idObject = self::ID_OBJECT;
  
  public $countInCart = 0;
  
  private static $_remainStatuses = null;
  
  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return Product the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'pr_product';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    $rules = array(
      array('countInCart', 'required', 'on' => 'cookie, offer'),
      array('countInCart', 'numerical', 'integerOnly'=>true, 'on' => 'cookie, offer'),
    );
    
    //Если не доступны заявки на заказ
    //то нужно проверять чтобы пользователь
    //не мог заказать больше чем есть на складе
    if (!Yii::app()->daShop->makeOfferByOrder) {
      $rules = array_merge($rules, array(
        array('countInCart', 'checkCountInCart', 'on' => 'cookie, offer')
      ));
    }
    
    return $rules;
  }
  
  public function checkCountInCart($attribute, $params = array()) {
    if ($this->countInCart > $this->remain) {
      $this->addError('countInCart', 'На складе нет данного количества товара.');
    }
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    return array(
      'mainPhoto' => array(self::HAS_ONE, 'File', array('id_file' => 'image'), 'select' => 'id_file, file_path, id_object, id_instance, id_parameter, id_property'),
      'category' => array(self::BELONGS_TO, 'ProductCategory', 'id_product_category', 'joinType' => 'INNER JOIN'),
      'brand' => array(self::BELONGS_TO, 'ProductBrand', 'id_brand'),
    );
  }

  public function behaviors() {
    //Берем конфигурацию из настроек модуля
    $config = HArray::val(Yii::app()->daShop->getModelConfig(__CLASS__), 'ImagePreview');
    return array(
      'photos' => array(
        'class' => 'PhotosBehavior',
        'idObject' => $this->getIdObject(),
      ),
      'ImagePreview' => CMap::mergeArray(array(
        'class' => 'ImagePreviewBehavior',
        'imageProperty' => 'mainPhoto',
        'formats' => array(
          '_list' => array(
            'width' => 100,
          ),
          '_one' => array(
            'width' => 300,
            'height' => 300,
          ),
          '_offer' => array(
            'width' => 50,
            'height' => 50,
          ),
        ),
      ), $config),
    );
  }
  
  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
      'id_product' => 'Id Product',
      'id_product_category' => 'Id Product Category',
      'code' => 'Code',
      'name' => 'Name',
      'trade_price' => 'Trade Price',
      'sm_trade_price' => 'Sm Trade Price',
      'retail_price' => 'Retail Price',
      'unit' => 'Unit',
      'remain' => 'Remain',
      'description' => 'Description',
      'deleted' => 'Deleted',
      'image' => 'Image',
      'countInCart' => 'Количество',
    );
  }
  
  public function defaultScope() {
    $alias = $this->getTableAlias(true, false);
    $criteria = new CDbCriteria(array(
      'condition' => $alias.'.deleted=0 AND '.$alias.'.visible=1',
      'order' => $alias.'.retail_price DESC',
    ));
    //Если отключена возможность заявок на товар под заказ
    if (!Yii::app()->daShop->makeOfferByOrder) {
      $criteria->addCondition($alias.'.remain > 0', 'AND');
    }
    return $criteria->toArray();
  }
  public function byCategory(ProductCategory $category, $limit = null) {
    $this->getDbCriteria()->mergeWith(array(
        'condition' => $this->getTableAlias().'.id_product_category=:category',
        'params' => array(':category' => $category->id_product_category),
        'limit' => $limit,
    ));
    return $this;
  }
  public function byBrand(ProductBrand $brand, $limit = null) {
    $this->getDbCriteria()->mergeWith(array(
        'condition' => $this->getTableAlias().'.id_brand=:brand',
        'params' => array(':brand' => $brand->id_brand),
        'limit' => $limit,
    ));
    return $this;
  }
  
  public function getUrl() {
    if (!$this->isNewRecord) {
      $name = HText::translit(mb_strtolower($this->name), "-");
      return Yii::app()->createUrl(ShopModule::ROUTE_PRODUCT, array('translitName' => $name, 'idProduct' => $this->id_product));
    }
    return '/';
  }
  public function getSearchTitle() {
    return $this->name;
  }
  public function getSearchUrl() {
    return $this->getUrl();
  }
  
  public function getPriceWithMarkup() {
    $productTradePrice = $this->retail_price;
    $productCategory = $this->category;
    if ($productCategory !== null) {
      $productCategoryPriceMarkup = $productCategory->price_markup;
      return ($productTradePrice + ($productTradePrice * $productCategoryPriceMarkup / 100));
    }
    return null;
  }
  /**
   * Итоговая сумма по товару в заказе
   * @return number
   */
  public function getOfferSum() {
    return $this->countInCart * $this->getPriceWithMarkup();
  }
  
  public static function price2str($price) {
    return Yii::app()->numberFormatter->format('#,##0.00', $price);
  }
  
  public static function getRemainStatuses() {
    if (self::$_remainStatuses === null) {
      self::$_remainStatuses = RemainStatus::model()->findAll();
    }
    return self::$_remainStatuses;
  }
  
  public function getRemainStatus() {
    foreach (self::getRemainStatuses() as $status) {
      if ((int)$this->remain > (int)$status->min_value
          && (int)$this->remain <= (int)$status->max_value) {
        return $status;
      }
    }
    return null;
  }
  
}