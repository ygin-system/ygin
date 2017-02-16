<?php

class VotePlugin extends PluginAbstract {
  
  public static function createPlugin(array $config) {
    return new VotePlugin();
  }
  
  public function getName() {
    return 'Опросы';
  }
  public function getVersion() {
    return '1.0';
  }
  public function getVersionDate() {
    return '22.08.2012'; // формат?
  }
  public function getShortDescription() {
    return 'Инструмент для создания на сайте опросов.';
  }
  
  public function getParametersValueFromConfig($config, $data) {
    if (isset($config['modules']['ygin.vote'])) return $config['modules']['ygin.vote'];
    return array();
  }
  public function getSettingsOfParameters() {
    return array(
        'checkByCookie' => array(
            'type' => DataType::BOOLEAN,
            'default' => true,
            'label' => 'Контроль по cookies',
            'required' => false,
        ),
        'expiredTimout' => array(
            'type' => DataType::INT,
            'default' => 24,
            'label' => 'Время блокирования',
            'description' => 'Количество часов, в течение которых пользователю будет запрещено повторно голосовать',
            'required' => true,
        ),
        'checkByIp' => array(
            'type' => DataType::BOOLEAN,
            'default' => true,
            'label' => 'Контроль по ip',
            'required' => false,
        ),
        'numVoteIp' => array(
            'type' => DataType::INT,
            'default' => 1,
            'label' => 'Допустимое количество голосов с одного ip-адреса',
            'description' => 'При включенной опции Контроль по ip',
            'required' => true,
        ),
    );
    
  }
  public function getConfigByParamsValue(array $paramsValue, $data) {
    return array('modules' => array('ygin.vote' => $paramsValue));
  }
  
  public function install(Plugin $plugin) {
    $plugin->setData(array(
        'id_php_script_type_module' => 1041,
        'id_object_voting' => 105,
        'id_object_voting_answer' => 106,
    ));
  }
  public function activate(Plugin $plugin) {
    $data = $plugin->getData();
    if ($data === null) $data = array();
    if (isset($data['id_menu']) && is_numeric($data['id_menu'])) { // не должно быть такого
      return;
    }
    if (Menu::model()->exists('id=:id', array(':id'=>116))) {
      // на сайте изначально был установлен данный плагин.
      // записываем данные по умолчанию
      $data['id_menu'] = 116;
      $data['id_site_module'] = 114;
    } else {
      // модуль ещё не установлен на сайте
      // создаем раздел меню и модуль сайта
      $menu = $this->prepareMenu( 
              'Опрос',
              'Опрос',
              'vote',
              '/vote/',
              (isset($data['id_menu_module_template']) ? $data['id_menu_module_template'] : null),
              false // обычно всем нужен только модуль, поэтому страницу со списком по умолчанию скроем
      );
      $menu->save();
      
      $siteModule = $this->prepareSiteModule('Голосование', $data['id_php_script_type_module']);
      $siteModule->save();
      
      if (!empty($data['site_module_place'])) {
        $this->restoreSiteModulePlace($siteModule->id_module, $data['site_module_place']);
        unset($data['site_module_place']);
      }
      
      $this->createPermission($data['id_object_voting'], 'Просмотр списка данных объекта Опросы');
      $this->createPermission($data['id_object_voting_answer'], 'Просмотр списка данных объекта Варианты ответов в опросах');
      
      $this->updateMenu = true;
      
      $data['id_menu'] = $menu->id;
      $data['id_site_module'] = $siteModule->id_module;
    }
    $plugin->setData($data);
  }
  public function deactivate(Plugin $plugin) {
    $data = $plugin->getData();
    if ($data === null || !isset($data['id_menu'])) {
      throw new ErrorException('Плагин установлен неверно.');
    }
    
    $data = $this->deleteMenu($data['id_menu'], $data, 'id_menu_module_template');
    $data = $this->deleteSiteModule($data['id_site_module'], $data, 'site_module_place');
    
    Yii::app()->authManager->removeAuthItemObject('list', $data['id_object_voting']);
    Yii::app()->authManager->removeAuthItemObject('list', $data['id_object_voting_answer']);
    $this->updateMenu = true;
    
    unset($data['id_menu'], $data['id_site_module']);
    
    $plugin->setData($data);
  }

}
