<?php

class FeedbackPlugin extends PluginAbstract {
  
  public static function createPlugin(array $config) {
    return new FeedbackPlugin();
  }
  
  public function getName() {
    return 'Обратная связь';
  }
  public function getVersion() {
    return '1.0';
  }
  public function getVersionDate() {
    return '21.08.2012'; // формат?
  }
  public function getShortDescription() {
    return 'Форма обратной связи.';
  }
  
  public function getParametersValueFromConfig($config, $data) {
    if (isset($config['modules']['ygin.feedback'])) {
      $params = $config['modules']['ygin.feedback'];
      if (isset($params['idEventType'])) {
        unset($params['idEventType']);
      }
      return $params;
    }
    return array();
  }
  public function getConfigByParamsValue(array $paramsValue, $data) {
    if (isset($data['id_event_type'])) {
      $paramsValue['idEventType'] = $data['id_event_type'];
    }
    return array('modules' => array('ygin.feedback' => $paramsValue));
  }
  
  public function install(Plugin $plugin) {
    $plugin->setData(array(
        'id_php_script_type_module' => 1037,
        'id_object' => 517,
    ));
  }
  public function activate(Plugin $plugin) {
    $data = $plugin->getData();
    if ($data === null) $data = array();
    if (isset($data['id_site_module']) && is_numeric($data['id_site_module'])) { // не должно быть такого
      return;
    }
    if (SiteModule::model()->exists('id_module=:id', array(':id'=>107))) {
      // на сайте изначально был установлен данный плагин.
      // записываем данные по умолчанию
      $data['id_site_module'] = 107;
      $data['id_event_type'] = 105;
    } else {
      $eventType = $this->prepareEventType('Новое сообщение с формы обратной связи');
      $eventType->save();
      $data['id_event_type'] = $eventType->id_event_type;
      
      // модуль ещё не установлен на сайте
      $siteModule = $this->prepareSiteModule('Кнопка обратной связи', $data['id_php_script_type_module']);
      $siteModule->save();
      $data['id_site_module'] = $siteModule->id_module;
      
      if (!empty($data['site_module_place'])) {
        $this->restoreSiteModulePlace($siteModule->id_module, $data['site_module_place']);
        unset($data['site_module_place']);
      }
      
      $this->createPermission($data['id_object'], 'Просмотр списка данных объекта Обратная связь');
      
      $this->updateMenu = true;
    }
    $plugin->setData($data);
    $plugin->setConfig($this->getConfigByParamsValue($plugin->getParamsValue(), $data));
  }
  
  public function deactivate(Plugin $plugin) {
    $data = $plugin->getData();
    if ($data === null || !isset($data['id_site_module'])) {
      throw new ErrorException('Плагин установлен неверно.');
    }
    
    $data = $this->deleteSiteModule($data['id_site_module'], $data, 'site_module_place');
    
    // Удаляем: все отправленные и неотправленные события по типу события + подписчиков + тип события
    $eventType = NotifierEventType::model()->findByPk($data['id_event_type']);
    if ($eventType != null) {
      $eventType->delete();
    }

    Yii::app()->authManager->removeAuthItemObject('list', $data['id_object']);
    $this->updateMenu = true;
    
    unset($data['id_site_module'], $data['id_event_type']);
    
    $plugin->setData($data);
  }
  
}