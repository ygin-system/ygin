<?php

class CloudimPlugin extends PluginAbstract {
  
  public static function createPlugin(array $config) {
    return new CloudimPlugin();
  }
  
  public function getName() {
    return 'Онлайн-консультант';
  }
  public function getVersion() {
    return '1.0';
  }
  public function getVersionDate() {
    return '28.08.2012'; // формат?
  }
  public function getShortDescription() {
    return 'Инструмент для общения с пользователями сайта.';
  }
  
  public function getParametersValueFromConfig($config, $data) {
    if (isset($config['components']['widgetFactory']['widgets']['CloudimWidget']))
      return $config['components']['widgetFactory']['widgets']['CloudimWidget'];
    return array();
  }
  public function getSettingsOfParameters() {
    return array(
        'htmlCode' => array(
            'type' => DataType::TEXTAREA,
            'default' => '',
            'label' => 'HTML-код',
            'description' => 'HTML-код можно получить на странице http://cloudim.ru/install',
            'required' => true,
        ),
    );
  }
  public function getConfigByParamsValue(array $paramsValue, $data) {
    return array('components'=>array(
      'widgetFactory' => array(
        'widgets' => array(
          'CloudimWidget' => $paramsValue
        ),
      ),
    ));
  }
  
  public function install(Plugin $plugin) {
    $plugin->setData(array(
        'id_php_script_type_module' => 1044,
    ));
  }
  public function activate(Plugin $plugin) {
    $data = $plugin->getData();
    if ($data === null) $data = array();
    if (isset($data['id_site_module']) && is_numeric($data['id_site_module'])) { // не должно быть такого
      return;
    }
    // модуль ещё не установлен на сайте
    // создаем раздел меню и модуль сайта
    $siteModule = $this->prepareSiteModule('online-консультант Cloudim', $data['id_php_script_type_module']);
    $siteModule->save();

    if (!empty($data['site_module_place'])) {
      $this->restoreSiteModulePlace($siteModule->id_module, $data['site_module_place']);
      unset($data['site_module_place']);
    }

    $data['id_site_module'] = $siteModule->id_module;

    $plugin->setData($data);
  }
  public function deactivate(Plugin $plugin) {
    $data = $plugin->getData();
    if ($data === null || !isset($data['id_site_module'])) {
      throw new ErrorException('Плагин установлен неверно.');
    }
    
    $data = $this->deleteSiteModule($data['id_site_module'], $data, 'site_module_place');
    
    unset($data['id_site_module']);
    
    $plugin->setData($data);
  }
}