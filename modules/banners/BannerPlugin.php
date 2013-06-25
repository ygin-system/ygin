<?php

class BannerPlugin extends PluginAbstract {
  
  public static function createPlugin(array $config) {
    return new BannerPlugin();
  }
  
  public function getName() {
    return 'Баннеры';
  }
  public function getVersion() {
    return '1.0';
  }
  public function getVersionDate() {
    return '24.08.2012'; // формат?
  }
  public function getShortDescription() {
    return 'Общий инструмент, предназначенный для хранения баннеров и учета их посещаемости.';
  }
  
  public function getParametersValueFromConfig($config, $data) {
    if (isset($config['modules']['ygin.banners'])) return $config['modules']['ygin.banners'];
    return array();
  }
  public function getConfigByParamsValue(array $paramsValue, $data) {
    return array('modules' => array('ygin.banners' => $paramsValue));
  }
  
  public function install(Plugin $plugin) {
    $plugin->setData(array(
        'id_object_banner_place' => 261,
        'id_object_banner' => 260,
    ));
  }
  public function activate(Plugin $plugin) {
    $data = $plugin->getData();

    $this->createPermission($data['id_object_banner_place'], 'Просмотр списка данных объекта Баннерные места');
    $this->createPermission($data['id_object_banner'], 'Просмотр списка данных объекта Баннеры');
      
    $this->updateMenu = true;
  }
  public function deactivate(Plugin $plugin) {
    $data = $plugin->getData();

    Yii::app()->authManager->removeAuthItemObject('list', $data['id_object_banner_place']);
    Yii::app()->authManager->removeAuthItemObject('list', $data['id_object_banner']);
    $this->updateMenu = true;
  }
  
}