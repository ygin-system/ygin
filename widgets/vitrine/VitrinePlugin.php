<?php

class VitrinePlugin extends PluginAbstract {
  
  public static function createPlugin(array $config) {
    return new VitrinePlugin();
  }
  
  public function getName() {
    return 'Витрина';
  }
  public function getVersion() {
    return '1.0';
  }
  public function getVersionDate() {
    return '28.08.2012'; // формат?
  }
  public function getShortDescription() {
    return 'Инструмент для размещения чередующихся рекламных блоков.';
  }
  
  public function install(Plugin $plugin) {
    $plugin->setData(array(
        'id_php_script_type_module' => 1039,
        'id_object' => 520,
    ));
  }
  public function activate(Plugin $plugin) {
    $data = $plugin->getData();
    if ($data === null) $data = array();
    if (isset($data['id_site_module']) && is_numeric($data['id_site_module'])) { // не должно быть такого
      return;
    }
    if (SiteModule::model()->exists('id_module=:id', array(':id'=>112))) {
      // на сайте изначально был установлен данный плагин.
      // записываем данные по умолчанию
      $data['id_site_module'] = 112;
    } else {
      $siteModule = $this->prepareSiteModule('Витрина', $data['id_php_script_type_module']);
      $siteModule->save();
      
      if (!empty($data['site_module_place'])) {
        $this->restoreSiteModulePlace($siteModule->id_module, $data['site_module_place']);
        unset($data['site_module_place']);
      }
      
      $this->createPermission($data['id_object'], 'Просмотр списка данных объекта Витрина');
      
      $this->updateMenu = true;
      
      $data['id_site_module'] = $siteModule->id_module;
    }
    $plugin->setData($data);
  }
  public function deactivate(Plugin $plugin) {
    $data = $plugin->getData();
    if ($data === null || !isset($data['id_site_module'])) {
      throw new ErrorException('Плагин установлен неверно.');
    }
    
    $data = $this->deleteSiteModule($data['id_site_module'], $data, 'site_module_place');
    
    Yii::app()->authManager->removeAuthItemObject('list', $data['id_object']);
    $this->updateMenu = true;
    
    unset($data['id_site_module']);
    
    $plugin->setData($data);
  }
  
}