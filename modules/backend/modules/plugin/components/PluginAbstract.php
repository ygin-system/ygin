<?php

abstract class PluginAbstract extends CComponent implements IApplicationPlugin {
  
  protected $updateMenu = false;
  
  public static function createPlugin(array $config) {
    throw new ErrorException('Не реализован обязательный метод createPlugin');
  }
  
  public function isMenuChange() {
    return $this->updateMenu;
  }  
  public function getName() {
    return null;
  }
  public function getVersion() {
    return null;
  }
  public function getVersionDate() {
    return null;
  }
  public function getShortDescription() {
    return null;
  }
  public function getDescription() {
    return null;
  }
  public function getImage() {
    return null;
  }
  public function getLink() {
    return null;
  }
  
  public function getDepends() {
    return array();
  }
  
  public function getParametersValueFromConfig($config, $data) {
    return array();
  }
  public function getSettingsOfParameters() {
    return array();
  }
  public function getConfigByParamsValue(array $paramsValue, $data) {
    return array();
  }
  
  public function install(Plugin $plugin) {
  }
  public function activate(Plugin $plugin) {
  }
  public function deactivate(Plugin $plugin) {
  }
  public function uninstall() {
    return null;
  }
  public function updatePlugin(Plugin $plugin) {
  }

  public function onChangeConfig(Plugin $plugin) {
  }
  
  public function prepareEventType($name, $idMailAccount=null, $interval=90) {
    $eventType = new NotifierEventType();
    $eventType->interval_value = $interval;
    $eventType->name = $name;
    if ($idMailAccount == null) {
      $mailAccount = NotifierMailAccount::model()->find();
      if ($mailAccount == null) {
        throw new ErrorException('Невозможно установить плагин, т.к. в системе не заведено почтовых аккаунтов.');
      }
      $eventType->id_mail_account = $mailAccount->getPrimaryKey();//primaryKey();
    } else {
      $eventType->id_mail_account = $idMailAccount;
    }
    return $eventType;
  }
  public function prepareMenu($name, $caption, $urlAlias, $extLink, $idModuleTemplate=null, $visible=true, $removable=false) {
    $menu = new Menu();
    $menu->name = $name;
    $menu->caption = $caption;
    $menu->setVisible($visible);
    $menu->alias = $urlAlias;
    $menu->external_link = $extLink;
    $menu->removable = $removable;
    if ($idModuleTemplate != null && SiteModuleTemplate::model()->exists('id_module_template=:id', array(':id'=>$idModuleTemplate)) ) {
      $menu->id_module_template = $idModuleTemplate;
    } else {
      $menu->id_module_template = SiteModuleTemplate::getIdDefaultTemplate();
    }
    return $menu;
  }
  public function activatePhpScript($idPhpScriptType) {
    $phpScriptType = PhpScript::model()->resetScope()->findByPk($idPhpScriptType);
    if ($phpScriptType == null) throw new Exception('Не удалось загрузить пхп-скрипт. ИД='.$idPhpScriptType);
    $phpScriptType->active = 1;
    $phpScriptType->save();
  }
  public function deactivatePhpScript($idPhpScriptType) {
    $phpScriptType = PhpScript::model()->resetScope()->findByPk($idPhpScriptType);
    if ($phpScriptType == null) throw new Exception('Не удалось загрузить пхп-скрипт. ИД='.$idPhpScriptType);
    $phpScriptType->active = 0;
    $phpScriptType->save();
  }
  public function prepareSiteModule($name, $idPhpScriptType, $params = array(), $visible = true) {
    $this->activatePhpScript($idPhpScriptType);

    $phpScript = new PhpScriptInstance();
    $phpScript->id_php_script_type = $idPhpScriptType;
    $phpScript->setParametersValue($params);
    $phpScript->save();

    $siteModule = new SiteModule();
    $siteModule->id_php_script = $phpScript->id_php_script;
    $siteModule->name = $name;
    $siteModule->setIsVisible($visible);
    
    return $siteModule;
  }
  public function restoreSiteModulePlace($idSiteModule, array $placeConfig) {
    foreach ($placeConfig AS $place) {
      if (SiteModuleTemplate::model()->exists('id_module_template=:id', array(':id' => $place['id_module_template']))) {
        $siteModulePlace = new SiteModulePlace();
        $siteModulePlace->id_module = $idSiteModule;
        $siteModulePlace->sequence = $place['sequence'];
        $siteModulePlace->place = $place['place'];
        $siteModulePlace->id_module_template = $place['id_module_template'];
        $siteModulePlace->save();
      }
    }
  }
  
  public function createPermission($idObject, $name, $role = 'editor') {
    $op = Yii::app()->authManager->getAuthItemObject('list', $idObject);
    if ($op == null) {
      $op = Yii::app()->authManager->createOperationForObject('list', $idObject, $name);
    }
    // временный зашивон TODO
    $role = Yii::app()->authManager->getAuthItem($role);
    if (!Yii::app()->authManager->hasItemChild($role->getName(), $op->getName())) {
      $role->addChild($op->getName());
    }    
  }
  public function createModulePlaceConfig(array $places) {
    $result = array();
    foreach ($places AS $place) {
      $result[] = array(
          'place' => $place->place,
          'sequence' => $place->sequence,
          'id_module_template' => $place->id_module_template
      );
    }
    return $result;
  }
  
  public function deleteMenu($idMenu, $data, $idModuleTemplateKey=null) {
    /**
     * @var $menu Menu
     */
    $menu = Menu::model()->findByPk($idMenu);
    if ($menu != null) {
      if ($idModuleTemplateKey != null) {
        if ($menu->id_module_template == SiteModuleTemplate::getIdDefaultTemplate() && isset($data[$idModuleTemplateKey]) ) {
          unset($data[$idModuleTemplateKey]);
        } else {
          $data[$idModuleTemplateKey] = $menu->id_module_template;
        }
      }
      $menu->removable = true;
      $menu->update(array('removable'));
      $menu->delete();
    }
    return $data;
  }
  public function deleteSiteModule($idSiteModule, $data, $siteModulePlaceKey) {
    $siteModule = SiteModule::model()->with('places')->findByPk($idSiteModule);
    if ($siteModule != null) {
      if ($siteModule->id_php_script != null) {
        $phpScriptInstance = $siteModule->phpScriptInstance;
        $this->deactivatePhpScript($phpScriptInstance->id_php_script_type);
      }
      $data[$siteModulePlaceKey] = $this->createModulePlaceConfig($siteModule->places);
      $siteModule->delete();
    }
    return $data;
  }

}