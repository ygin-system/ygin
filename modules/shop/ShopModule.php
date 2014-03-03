<?php
Yii::import('ygin.modules.shop.models.Offer');

class ShopModule extends DaWebModuleAbstract implements IApplicationComponent {
  
  const ROUTE_PRODUCT_CATEGORY = 'shop/product/category';
  const ROUTE_PRODUCT_BRAND = 'shop/product/brand';
  const ROUTE_PRODUCT = 'shop/product/view';
  const ROUTE_OFFER = 'shop/offer';
  const ROUTE_MAIN = 'shop/product/index';
  const ROUTE_EXPORT_YANDEX_MARKET = 'shop/exportYandexMarket/index';
  
  const DISPAY_TYPE_ALL = 'all';
  const DISPAY_TYPE_ONLY_PRODUCT = 'product';
  const DISPAY_TYPE_ONLY_CATEGORY = 'category';
  
  const CART_COOKIE_NAME = 'daCart';
  
  public $idEventTypeNewOffer;
  
  public $showPrice = true;
  public $subCategoryOnMain = true;
  public $imageCategoryOnMain = true;
  public $viewProductList = '_product_list_table';
  public $pageSize = 10;
  public $displayTypeElements = self::DISPAY_TYPE_ALL; // 'all', 'product', 'category'

  /**
   * Доступна ли возможность делать заявки на заказ
   * (т.е. когда продукции на складе меньше, чем указано в заявке)
   * @var boolean
   */
  public $makeOfferByOrder = false;
  /**
   * Статус, при котором списывается товар при оформлении заказа.
   * @var integer
   */
  public $debitOfferStatus = Offer::STATUS_NEW;
  /**
   * Статус, при котором товар приходуется (возвращается на склад) при отмене заказа.
   * @var integer
   */
  public $creditOfferStatus = Offer::STATUS_CANCELED;
  /**
   * Отображать ли тулбар в списке продукции.
   * @var boolean
   */
  public $showToolbar = false;
  /**
   * Использовать ли онлайн-оплату через агрегаторов платежей (робокасса, монета.ру)
   * @var boolean
   */
  public $useOnlinePayment = false;

  private $_currentIdCategory = null;
  
  private static $_productsCookie = null;
  
  protected $_urlRules = array(
    'catalog/' => ShopModule::ROUTE_MAIN,
    'catalog/offer' => ShopModule::ROUTE_OFFER,
    'catalog/<translitName:[\w-\.]+>-cat-<idCategory:\d+>/*' => ShopModule::ROUTE_PRODUCT_CATEGORY,
    'catalog/<translitName:[\w-\.]+>-brand-<idBrand:\d+>' => ShopModule::ROUTE_PRODUCT_BRAND,
    'catalog/<translitName:[\w-\.]+>-prod-<idProduct:\d+>' => ShopModule::ROUTE_PRODUCT,
    'catalog/export/yandex-market/<key:[\w-]+>' => ShopModule::ROUTE_EXPORT_YANDEX_MARKET,
  );

  public $exportKey = 'ygin';
  public $exportCriteria = array();
  public $exportTimeout = 10800; // три часа
  
  /**
   * Конфигурация моделей
   * @var array
   */
  protected $modelsConfig = array(
    'Product' => array(
      'ImagePreview' => array(
        'formats' => array(
          '_list' => array(
            'width' => 100,
            //'height' => 75,
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
      ),
    ),
    'ProductCategory' => array(
      'ImagePreview' => array(
        'formats' => array(
          '_sm' => array(
            'width' => 170,
            'height' => 130,
          ),
        ),
      ),
    ),
  );
  
  public function getModelsConfig() {
  	return $this->modelsConfig;
  }
  
  public function setModelsConfig($config) {
    $this->modelsConfig = $config;
  }
  
  public function getModelConfig($modelClass) {
    return HArray::val($this->getModelsConfig(), $modelClass, array());
  }
  
  public function init() {
    $this->setImport(array(
      'shop.models.*',
      'shop.controllers.*',
      'shop.components.*',
      'zii.behaviors.CTimestampBehavior',
    ));

    Yii::app()->setComponent('daShop', $this);
  }
  
  public function getIsInitialized() {
    return true;
  }
  
  public function setCurrentIdCategory($idCategory) {
    if (!is_numeric($idCategory)) return;
    $this->_currentIdCategory = $idCategory;
    
    // настраиваем цепочку навигаций
    if (isset(Yii::app()->controller->breadcrumbs)) {
      $tree = ProductCategory::model()->getTree();
      $currentCategory = $tree->getById($idCategory);
      $arr = array();
      while($currentCategory != null) {
        $arr[$currentCategory->name] = $currentCategory->getUrl();
        $currentCategory = $currentCategory->getParent();
      }
      
      if (count($arr) > 0) {
        Yii::app()->controller->breadcrumbs = array_merge(Yii::app()->controller->breadcrumbs, array_reverse($arr));
      }
    }
    
  }
  public function getCurrentIdCategory() {
    return $this->_currentIdCategory;
  }

  public static function getProductsFromCookie() {
    if (ShopModule::$_productsCookie !== null) return ShopModule::$_productsCookie;
    $productsFromCookie = array();
    if (isset(Yii::app()->request->cookies[self::CART_COOKIE_NAME])) {
      $productsFromCookie = CJSON::decode(Yii::app()->request->cookies[self::CART_COOKIE_NAME]->value, true);
    }
    ShopModule::$_productsCookie = array();
    if (isset($productsFromCookie) && is_array($productsFromCookie)) {
      $cartProducts = Product::model()->with('category')->findAllByPk(HArray::column($productsFromCookie, 'id'));
      $collection = new DaActiveRecordCollection($cartProducts);
      foreach ($productsFromCookie as $productCookieItem) {
        $count = HArray::val($productCookieItem, 'count', 0);
        $idProduct = HArray::val($productCookieItem, 'id');
        if ($count == 0) continue;
        $product = $collection->itemAt($idProduct);
        if ($product == null) continue;
        //чтобы появилась возможность заполнять кастомные поля (поля, определенные прикладным программистом)
        //делаем массовое присваивание
        $product->scenario = 'cookie';
        unset($productCookieItem['id'], $productCookieItem['count']);
        $product->attributes = CMap::mergeArray(array('countInCart' => $count), $productCookieItem);
        ShopModule::$_productsCookie[] = $product;
      }
    }
    return ShopModule::$_productsCookie;
  }
  public static function clearProductsFromCookie() {
    ShopModule::$_productsCookie = array();
    unset(Yii::app()->request->cookies[self::CART_COOKIE_NAME]);
  }

}
