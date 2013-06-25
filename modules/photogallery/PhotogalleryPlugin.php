<?php

class PhotogalleryPlugin extends PluginAbstract {
  
  public static function createPlugin(array $config) {
    return new PhotogalleryPlugin();
  }
  
  public function getName() {
    return 'Фотогалерея';
  }
  public function getVersion() {
    return '1.0';
  }
  public function getVersionDate() {
    return '19.08.2012'; // формат?
  }
  public function getShortDescription() {
    return 'Инструмент для публикации галерей и привязки фотографий к другим объектам.';
  }
  public function getDescription() {
    return 'Инструмент для публикации галерей и привязки фотографий к другим объектам.';
  }
  
  public function getParametersValueFromConfig($config, $data) {
    return array('useGallery' => $data['useGallery']);
  }
  public function getSettingsOfParameters() {
    return array(
        'useGallery' => array(
            'type' => DataType::BOOLEAN,
            'default' => true,
            'label' => 'Использовать на сайте раздел галереи',
            'description' => null,
            'required' => false,
        ),
    );
  }
  public function getConfigByParamsValue(array $paramsValue, $data) {
    $useGallery = $this->getSettingsOfParameters();
    $useGallery = $useGallery['useGallery']['default'];
    if (isset($paramsValue['useGallery'])) {
      $useGallery = (bool)$paramsValue['useGallery'];
    }
    $config = array();
    if (!$useGallery) {
      $config['urlRules'] = array('photogallery' => null, 'photogallery/<idGallery:\d+>' => null);
    }
    return array('modules' => array('ygin.photogallery' => $config));
  }
  
  public function install(Plugin $plugin) {
    $useGallery = $this->getSettingsOfParameters();
    $useGallery = $useGallery['useGallery']['default'];
    $plugin->setData(array(
        'id_object_gallery' => 500,
        'id_object_photo' => 501,
        'handler_column' => 1001,
        'useGallery' => $useGallery,
    ));
  }
  public function activate(Plugin $plugin) {
    $data = $plugin->getData();
    if ($data === null) $data = array();

    // настройка галереи просто как хранилища фотографий
    $this->createPermission($data['id_object_photo'], 'Просмотр списка данных объекта Фотографии');
    
    $this->updateMenu = true;

    // галерея
    if (!isset($data['useGallery']) || $data['useGallery'] === false) return;
    $plugin->setData($this->installGallery($data));
  }
  public function deactivate(Plugin $plugin) {
    $data = $plugin->getData();
    if ($data === null) {
      throw new ErrorException('Плагин установлен неверно.');
    }
    Yii::app()->authManager->removeAuthItemObject('list', $data['id_object_photo']);
    $this->updateMenu = true;
    $plugin->setData($this->uninstallGallery($data));
  }
  
  public function onChangeConfig(Plugin $plugin) {
    $config = $plugin->getConfig();
    $data = $plugin->getData();
    
    $useGallery = $this->getSettingsOfParameters();
    $useGallery = $useGallery['useGallery']['default'];
    if (isset($config['useGallery'])) {
      $useGallery = (bool)$config['useGallery'];
    }
    $data['useGallery'] = $useGallery;
  
    if ($useGallery) {
      $data = $this->installGallery($data);
    } else {
      $data = $this->uninstallGallery($data);
    }
    $plugin->setData($data);
  }
  
  private function installGallery(array $data) {
    $data = $this->setupRandomPhotoWidget($data);
    if (isset($data['id_menu']) && is_numeric($data['id_menu'])) { // уже установлено
      return $data;
    }
    if (Menu::model()->exists('id=:id', array(':id'=>101))) {
      // на сайте изначально был установлен данный плагин.
      // записываем данные по умолчанию
      $data['id_menu'] = 101;
    } else {
      // модуль ещё не установлен на сайте
      // создаем раздел меню и модуль сайта
      $menu = $this->prepareMenu(
              'Фотогалерея',
              'Фотогалерея',
              'photogallery',
              '/photogallery/',
              (isset($data['id_menu_module_template']) ? $data['id_menu_module_template'] : null)
      );
      $menu->save();
      $data['id_menu'] = $menu->id;
      
      $this->createPermission($data['id_object_gallery'], 'Просмотр списка данных объекта Галерея');
    }
    return $data;
  }
  private function uninstallGallery(array $data) {
    if (!isset($data['id_menu'])) return $data;
    $data = $this->deleteMenu($data['id_menu'], $data, 'id_menu_module_template');
    unset($data['id_menu']);
    Yii::app()->authManager->removeAuthItemObject('list', $data['id_object_gallery']);
    $data = $this->removeRandomPhotoWidget($data);
    return $data;
  }
  
  public function updatePlugin(Plugin $plugin) {
    $data = $plugin->getData();
    if (!isset($data['id_php_script_type_widget_random_photo'])) {
      $data['id_php_script_type_widget_random_photo'] = 1045;
    }
    if ($plugin->getIsEnabled()) {
      if (isset($data['useGallery']) && $data['useGallery'])
        $data = $this->setupRandomPhotoWidget($data);
    }
    $plugin->setData($data);
  }
  
  private function setupRandomPhotoWidget(array $data) {
    $siteModule = $this->prepareSiteModule('Случайное фото', $data['id_php_script_type_widget_random_photo']);
    $siteModule->save();
    if (!empty($data['widget_random_photo_place'])) {
      $this->restoreSiteModulePlace($siteModule->id_module, $data['widget_random_photo_place']);
      unset($data['widget_random_photo_place']);
    }
    $data['id_widget_random_photo'] = $siteModule->id_module;
    return $data;
  }
  
  private function removeRandomPhotoWidget(array $data) {
    $data = $this->deleteSiteModule($data['id_widget_random_photo'], $data, 'widget_random_photo_place');
    unset($data['id_widget_random_photo']);
    return $data;
  }
  
}