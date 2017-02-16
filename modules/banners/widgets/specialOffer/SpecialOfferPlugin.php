<?php

class SpecialOfferPlugin extends PluginAbstract {
  
  public static function createPlugin(array $config) {
    return new SpecialOfferPlugin();
  }
  
  public function getName() {
    return 'Спецпредложения';
  }
  public function getVersion() {
    return '1.0';
  }
  public function getVersionDate() {
    return '27.08.2012'; // формат?
  }
  public function getShortDescription() {
    return 'Публикация спецпредложений.';
  }
  
  public function install(Plugin $plugin) {
    $plugin->setData(array(
        'id_php_script_type_module' => 1040,
    ));
  }
  public function getDepends() {
    return array('ygin.banners');
  }
  public function activate(Plugin $plugin) {
    $data = $plugin->getData();
    if ($data === null) $data = array();
    if (isset($data['id_site_module']) && is_numeric($data['id_site_module'])) { // не должно быть такого
      return;
    }
    if (SiteModule::model()->exists('id_module=:id', array(':id'=>113))) {
      // на сайте изначально был установлен данный плагин.
      // записываем данные по умолчанию
      $data['id_site_module'] = 113;
    } else {
      $bp = new BannerPlace();
      $bp->title = 'Баннеры спецпредложений';
      $bp->showing = BannerPlace::ST_ALL;
      $bp->save();
      
      // модуль ещё не установлен на сайте
      $siteModule = $this->prepareSiteModule('Спецпредложения', $data['id_php_script_type_module'], array(
          'idBannerPlace'=>$bp->id_banner_place,
      ));
      $siteModule->save();
      
      if (!empty($data['site_module_place'])) {
        $this->restoreSiteModulePlace($siteModule->id_module, $data['site_module_place']);
        unset($data['site_module_place']);
      }
      
      $data['id_site_module'] = $siteModule->id_module;
    }
    $plugin->setData($data);
  }
  public function deactivate(Plugin $plugin) {
    $data = $plugin->getData();
    if ($data === null || !isset($data['id_site_module'])) {
      throw new ErrorException('Плагин установлен неверно.');
    }
    $siteModule = SiteModule::model()->findByPk($data['id_site_module']);
    $idBannerPlace = $siteModule->phpScriptInstance->getParameterValue('idBannerPlace');
    if (is_numeric($idBannerPlace) && ($bp=BannerPlace::model()->findByPk($idBannerPlace)) != null ) {
      if (count($bp->banners) == 0) {
        $bp->delete();
      }
    }
    
    $data = $this->deleteSiteModule($data['id_site_module'], $data, 'site_module_place');
    
    unset($data['id_site_module']);
    
    $plugin->setData($data);
  }
  
}