<?php

class NewsPlugin extends PluginAbstract {
  
  public static function createPlugin(array $config) {
    return new NewsPlugin();
  }
  
  public function getName() {
    return 'Новости';
  }
  public function getVersion() {
    return '1.2';
  }
  public function getVersionDate() {
    return '06.11.2012'; // формат?
  }
  public function getShortDescription() {
    return 'Инструмент для написания периодической информации.';
  }
  public function getDescription() {
    return 'Инструмент для написания периодической информации.<br>Позволяет вести новостную ленту, размещая различные медиа-данные.';
  }
  public function getImage() {
    return realpath(dirname(__FILE__).'/assets/news.gif');
  }
  
  public function getParametersValueFromConfig($config, $data) {
    if (isset($config['modules']['ygin.news'])) return $config['modules']['ygin.news'];
    return array();
  }
  public function getSettingsOfParameters() {
    return array(
        /*'itemsCountPerPage' => array(
            'type' => DataType::INT,
            'default' => 3,
            'label' => 'Количество новостей в модуле',
            'description' => null,
            'required' => true,
        ),*/
        'showCategories' => array(
            'type' => DataType::BOOLEAN,
            'default' => false,
            'label' => 'Использовать ли на сайте категории',
            'description' => null,
            'required' => false,
        ),
    );
  }
  public function getConfigByParamsValue(array $paramsValue, $data) {
    return array('modules' => array('ygin.news' => $paramsValue));
  }
  
  public function install(Plugin $plugin) {
    $plugin->setData(array(
        'id_php_script_type_module' => 1005,
        'id_object' => 502,
        'id_object_category' => 503,
    ));
  }
  public function activate(Plugin $plugin) {
    $data = $plugin->getData();
    if ($data === null) $data = array();
    if (isset($data['id_menu']) && is_numeric($data['id_menu'])) { // не должно быть такого
      return;
    }
    if (Menu::model()->exists('id=:id', array(':id'=>103))) {
      // на сайте изначально был установлен данный плагин.
      // записываем данные по умолчанию
      $data['id_menu'] = 103;
      $data['id_site_module'] = 100;
    } else {
      // модуль ещё не установлен на сайте
      // создаем раздел меню и модуль сайта
      $menu = $this->prepareMenu(
              'Новости',
              'Новости',
              'news',
              '/news/',
              (isset($data['id_menu_module_template']) ? $data['id_menu_module_template'] : null)
      );
      $menu->save();
      
      $siteModule = $this->prepareSiteModule('Последние новости', $data['id_php_script_type_module'], array(
         'maxNews'=>3,
      ));
      $siteModule->save();
      
      if (!empty($data['site_module_place'])) {
        $this->restoreSiteModulePlace($siteModule->id_module, $data['site_module_place']);
        unset($data['site_module_place']);
      }
      
      $this->createPermission($data['id_object'], 'Просмотр списка данных объекта Новости');
      
      $this->updateMenu = true;
      
      $data['id_menu'] = $menu->id;
      $data['id_site_module'] = $siteModule->id_module;
      
      $config = $plugin->getConfig();
      if (isset($config['modules']['ygin.news']['showCategories']) &&
          $config['modules']['ygin.news']['showCategories'] === true) {
        $this->installCategory($data);
      }
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
    
    Yii::app()->authManager->removeAuthItemObject('list', $data['id_object']);
    $this->updateMenu = true;
    
    unset($data['id_menu'], $data['id_site_module']);
    
    $this->uninstallCategory($data);
    
    $plugin->setData($data);
  }
  
  public function onChangeConfig(Plugin $plugin) {
    $config = $plugin->getConfig();
    $data = $plugin->getData();
    if (isset($config['modules']['ygin.news']['showCategories']) &&
        $config['modules']['ygin.news']['showCategories'] === true) {
      $this->installCategory($data);
    } else {
      $this->uninstallCategory($data);
    }
  }
  
  private function installCategory($data) {
    $this->createPermission($data['id_object_category'], 'Просмотр списка данных объекта Категории новостей');
    $columns = DaObjectViewColumn::model()->findAll('id_object=:id_object AND field_name=:field', array(':id_object'=>$data['id_object'], ':field'=>'id_news_category'));
    foreach($columns AS $column) {
      /**
       * @var $column DaObjectViewColumn
       */
      $column->visible = 1;
      $column->update(array('visible'));
    }
  }
  private function uninstallCategory($data) {
    Yii::app()->authManager->removeAuthItemObject('list', $data['id_object_category']);
    $columns = DaObjectViewColumn::model()->findAll('id_object=:id_object AND field_name=:field', array(':id_object'=>$data['id_object'], ':field'=>'id_news_category'));
    foreach($columns AS $column) {
      /**
       * @var $column DaObjectViewColumn
       */
      $column->visible = 0;
      $column->update(array('visible'));
    }
  }
  
  
}