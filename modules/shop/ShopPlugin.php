<?php

Yii::import('ygin.modules.shop.ShopModule');

class ShopPlugin extends PluginAbstract {
  
  public static function createPlugin(array $config) {
    return new ShopPlugin();
  }
  
  public function getName() {
    return 'Интернет-магазин';
  }
  public function getVersion() {
    return '1.0';
  }
  public function getVersionDate() {
    return '20.08.2012'; // формат?
  }
  public function getShortDescription() {
    return 'Каталог товаров, разбитый на категории, с возможностью оформления заявок.';
  }
  
  public function getParametersValueFromConfig($config, $data) {
    if (isset($config['modules']['ygin.shop'])) {
      $params = $config['modules']['ygin.shop'];
      if (isset($params['idEventTypeNewOffer'])) {
        unset($params['idEventTypeNewOffer']);
      }
      return $params;
    }
    return array();
  }
  public function getSettingsOfParameters() {
    return array(
      'pageSize' => array(
        'type' => DataType::INT,
        'default' => 10,
        'label' => 'Товаров на странице',
        'description' => null,
        'required' => true,
      ),
      'displayTypeElements' => array(
        'type' => DataType::RADIO,
        'default' => ShopModule::DISPAY_TYPE_ALL,
        'options' => array(ShopModule::DISPAY_TYPE_ALL => 'Вложенные категории и продукция категории', ShopModule::DISPAY_TYPE_ONLY_CATEGORY => 'Только вложенные категории', ShopModule::DISPAY_TYPE_ONLY_PRODUCT => 'Только продукцию категории'),
        'label' => 'Тип отображения элементов в категории',
        'description' => null,
        'required' => true,
      ),
      'viewProductList' => array(
        'type' => DataType::RADIO,
        'default' => '_product_list_table',
        'options' => array('_product_list_table' => 'Табличный', '_product_list' => 'Списком'),
        'label' => 'Вид отображения продукции по умолчанию',
        'description' => null,
        'required' => true,
      ),
      'showPrice' => array(
        'type' => DataType::BOOLEAN,
        'default' => true,
        'label' => 'Показывать цены',
        'description' => null,
        'required' => false,
      ),
      'subCategoryOnMain' => array(
        'type' => DataType::BOOLEAN,
        'default' => true,
        'label' => 'Показывать вложенные категории',
        'description' => null,
        'required' => false,
      ),
      'imageCategoryOnMain' => array(
        'type' => DataType::BOOLEAN,
        'default' => true,
        'label' => 'Показывать картинки в списке категорий',
        'description' => null,
        'required' => false,
      ),
      'makeOfferByOrder' => array(
        'type' => DataType::BOOLEAN,
        'default' => false,
        'label' => 'Возможность оставлять заказ на отсутствующий в наличие товар',
        'description' => null,
        'required' => false,
      ),
      'showToolbar' => array(
        'type' => DataType::BOOLEAN,
        'default' => false,
        'label' => 'Панель настоек в списке продукции',
        'description' => null,
        'required' => false,
      ),
      'useOnlinePayment' => array(
        'type' => DataType::BOOLEAN,
        'default' => false,
        'label' => 'Использовать ли системы онлайн-оплаты (Робокасса, Монета)',
        'description' => null,
        'required' => false,
      ),
    );
  }
  public function getConfigByParamsValue(array $paramsValue, $data) {
    if (isset($data['idEventTypeNewOffer'])) {
      $paramsValue['idEventTypeNewOffer'] = $data['idEventTypeNewOffer'];
    }
    return array('modules' => array('ygin.shop' => $paramsValue));
  }
  public function getDepends() {
    return array('ygin.photogallery');
  }
  
  public function install(Plugin $plugin) {
    $data = array(
      'id_php_script_type_module_category' => 1038,
      'id_php_script_type_module_cart' => 1010,
      'id_php_script_type_module_brand' => 1043,

      'id_object_product' => 511,
      'id_object_category' => 509,
      'id_object_offer' => 519,
      'id_object_brand' => 525,
      'id_object_remain_status' => 529,
      'id_object_invoice' => 'ygin-invoice',
    );
    $plugin->setData($data);
  }

  public function activate(Plugin $plugin) {
    $data = $plugin->getData();
    if ($data === null) $data = array();
    if (isset($data['id_menu']) && is_numeric($data['id_menu'])) { // не должно быть такого
      return;
    }
    if (Menu::model()->exists('id=:id', array(':id'=>106))) {
      // на сайте изначально был установлен данный плагин.
      // записываем данные по умолчанию
      $data['id_menu'] = 106;
      $data['id_site_module_category'] = 111;
      $data['id_site_module_cart'] = 109;
      $data['id_site_module_brand'] = 120;
      $data['idEventTypeNewOffer'] = 106;
    } else {
      $eventType = $this->prepareEventType('Оформлена новая заявка');
      $eventType->save();
      $data['idEventTypeNewOffer'] = $eventType->id_event_type;
      
      // модуль ещё не установлен на сайте
      // создаем раздел меню и модули сайта
      $menu = $this->prepareMenu(
              'Интернет-магазин',
              'Интернет-магазин',
              'catalog',
              '/catalog/',
              (isset($data['id_menu_module_template']) ? $data['id_menu_module_template'] : null)
      );
      $menu->save();
      
      $siteModule = $this->prepareSiteModule('Категории товаров', $data['id_php_script_type_module_category']);
      $siteModule->save();
      if (!empty($data['site_module_place_category'])) {
        $this->restoreSiteModulePlace($siteModule->id_module, $data['site_module_place_category']);
        unset($data['site_module_place_category']);
      }
      $data['id_site_module_category'] = $siteModule->id_module;
      
      $siteModule = $this->prepareSiteModule('Корзина', $data['id_php_script_type_module_cart'], array(
        'visibleCount' => 15,
      ));
      $siteModule->save();
      if (!empty($data['site_module_place_cart'])) {
        $this->restoreSiteModulePlace($siteModule->id_module, $data['site_module_place_cart']);
        unset($data['site_module_place_cart']);
      }
      $data['id_site_module_cart'] = $siteModule->id_module;
      
      $siteModule = $this->prepareSiteModule('Интернет-магазин-->Брэнды', $data['id_php_script_type_module_brand']);
      $siteModule->save();
      if (!empty($data['site_module_place_brand'])) {
        $this->restoreSiteModulePlace($siteModule->id_module, $data['site_module_place_brand']);
        unset($data['site_module_place_brand']);
      }
      $data['id_site_module_brand'] = $siteModule->id_module;
      
      $this->createPermission($data['id_object_product'], 'Просмотр списка данных объекта Продукция');
      $this->createPermission($data['id_object_category'], 'Просмотр списка данных объекта Категории продукции');
      $this->createPermission($data['id_object_offer'], 'Просмотр списка данных объекта Заказы');
      $this->createPermission($data['id_object_brand'], 'Просмотр списка данных объекта Брэнды продукции');
      if (!isset($data['id_object_remain_status'])) $data['id_object_remain_status'] = 529;
      $this->createPermission($data['id_object_remain_status'], 'Просмотр списка данных объекта Статусы остатков продукции');
      if (!isset($data['id_object_invoice'])) $data['id_object_invoice'] = 'id_object_invoice';
      $this->createPermission($data['id_object_invoice'], 'Просмотр списка данных объекта Счета');

      $this->updateMenu = true;
      $data['id_menu'] = $menu->id;
    }
    $plugin->setData($data);
  }
  public function deactivate(Plugin $plugin) {
    $data = $plugin->getData();
    if ($data === null || !isset($data['id_menu'])) {
      throw new ErrorException('Плагин установлен неверно.');
    }
    
    // Удаляем: все отправленные и неотправленные события по типу события + подписчиков + тип события
    $eventType = NotifierEventType::model()->findByPk(@$data['idEventTypeNewOffer']);
    if ($eventType != null) {
      $eventType->delete();
    }
    
    $data = $this->deleteMenu($data['id_menu'], $data, 'id_menu_module_template');
    $data = $this->deleteSiteModule($data['id_site_module_category'], $data, 'site_module_place_category');
    $data = $this->deleteSiteModule($data['id_site_module_cart'], $data, 'site_module_place_cart');
    $data = $this->deleteSiteModule($data['id_site_module_brand'], $data, 'site_module_place_brand');
    
    Yii::app()->authManager->removeAuthItemObject('list', $data['id_object_product']);
    Yii::app()->authManager->removeAuthItemObject('list', $data['id_object_category']);
    Yii::app()->authManager->removeAuthItemObject('list', $data['id_object_offer']);
    Yii::app()->authManager->removeAuthItemObject('list', $data['id_object_brand']);
    if (!isset($data['id_object_remain_status'])) $data['id_object_remain_status'] = 529;
    Yii::app()->authManager->removeAuthItemObject('list', $data['id_object_remain_status']);
    if (!isset($data['id_object_invoice'])) $data['id_object_invoice'] = 'id_object_invoice';
    Yii::app()->authManager->removeAuthItemObject('list', $data['id_object_invoice']);
    $this->updateMenu = true;
    
    unset($data['id_menu'], $data['id_site_module_category'], $data['id_site_module_cart'], $data['id_site_module_brand']);
    
    $plugin->setData($data);
  }

}