<?php
class CabinetPlugin extends PluginAbstract {
  
  public static function createPlugin(array $config) {
    return new CabinetPlugin();
  }
  
  public function getName() {
    return 'Личный кабинет';
  }
  public function getVersion() {
    return '0.1';
  }
  public function getVersionDate() {
    return '15.10.2012';
  }
  public function getShortDescription() {
    return 'Личный кабинет пользователя.';
  }
  public function getDescription() {
    return 'Личный кабинет пользователя с возможностью регистрации, авторизации, просмотра и редактирования профиля.';
  }
  public function getConfigByParamsValue(array $paramsValue, $data) {
    if ($data === null) $data = array();
    $params = array(
      'idEventTypeRecover',
      'idEventSubscriberRecover',
      'idEventTypeRegister',
    );
    foreach ($params as $paramName) {
      $paramsValue[$paramName] = HArray::val($data, $paramName);
    }
    $paramsValue['cabinetEnabled'] = HArray::val($data, 'cabinetEnabled', false);
    return array('modules' => array('ygin.user' => $paramsValue));
  }
  
  public function install(Plugin $plugin) {
    $data = array(
      'id_php_script_type_widget_authorize' => 1032,
      'id_system_module' => 1007,
    );
    $plugin->setData($data);
  }
  
  public function activate(Plugin $plugin) {
    $data = $plugin->getData();
    $data = $data === null ? array() : $data;
    $trans = Yii::app()->db->beginTransaction();
    $menuSections = array(
      array('label' => 'Авторизация', 'urlAlias' => 'login', 'extLink' => '/login/'),
      array('label' => 'Регистрация', 'urlAlias' => 'register', 'extLink' => '/register/'),
      array('label' => 'Восстановление пароля', 'urlAlias' => 'recover', 'extLink' => '/recover/'),
      array('label' => 'Профиль', 'urlAlias' => 'profile', 'extLink' => '/profile/'),
      array('label' => 'Пользователь', 'urlAlias' => 'user', 'extLink' => '/user/'),
    );
    //Создаем разделы меню
    foreach ($menuSections as $menuItem) {
      $idMenuKey = 'idMenu'.ucfirst($menuItem['urlAlias']);
      $menu = $this->prepareMenu(
        $menuItem['label'],
        $menuItem['label'],
        $menuItem['urlAlias'],
        $menuItem['extLink'],
        HArray::val($data, 'id_menu_module_template_'.$idMenuKey),
        false
      );
      $menu->save();
      $data[$idMenuKey] = $menu->primaryKey;
    }
    
    //создаем тип события
    $eventType = $this->prepareEventType('Восстановление пароля');
    $eventType->save();
    //и подписчика на событие
    $eventSubscriber = new NotifierEventSubscriber();
    $eventSubscriber->id_event_type = $eventType->primaryKey;
    $eventSubscriber->format = 1;
    $eventSubscriber->archive_attach = 0;
    $eventSubscriber->save();
    
    $data['idEventTypeRecover'] = $eventType->primaryKey;
    $data['idEventSubscriberRecover'] = $eventSubscriber->primaryKey;
    
    //тип события "Регистрация нового пользователя"
    $data = array_merge($data, $this->setupEventRegister());
    
    //если виджет уже есть
    if (SiteModule::model()->exists('id_module = :ID', array(':ID' => 108))) {
      $data['id_widget_authorize'] = 108;
    } else { //создаем виджет авторизации
      $siteModule = $this->prepareSiteModule('Авторизация', $data['id_php_script_type_widget_authorize']);
      $siteModule->save();
      if (!empty($data['widget_authorize_place'])) {
        $this->restoreSiteModulePlace($siteModule->id_module, $data['widget_authorize_place']);
        unset($data['widget_authorize_place']);
      }
      $data['id_widget_authorize'] = $siteModule->id_module;
    }
    
    //Включаем личный кабинет пользователя
    $data['cabinetEnabled'] = true;
    $plugin->setData($data);
    $trans->commit();
  }
  
  public function deactivate(Plugin $plugin) {
    $data = $plugin->getData();
    if (!is_array($data)) {
      throw new ErrorException('Плагин установлен неверно.');
    }
    
    $trans = Yii::app()->db->beginTransaction();
    $idMenuKeys = array('idMenuLogin', 'idMenuRegister', 'idMenuRecover', 'idMenuProfile', 'idMenuUser');
    //если в массиве $data нет всех ключей из $idMenuKeys
    if (count(array_diff($idMenuKeys, array_keys($data))) > 0) {
      throw new ErrorException('Плагин установлен неверно.');
    }
    //удаляем разделы меню
    foreach ($idMenuKeys as $idMenuKey) {
      $data = $this->deleteMenu($data[$idMenuKey], $data, 'id_menu_module_template_'.$idMenuKey);
      unset($data[$idMenuKey]);
    }
    //удаляем типы событий
    $paramNames = array('idEventTypeRecover', 'idEventTypeRegister');
    $etIds = array();
    foreach ($paramNames as $paramName) {
      if ($id = HArray::val($data, $paramName)) {
        $etIds[] = $id;
      }
    }
    if ($etIds) {
      foreach (NotifierEventType::model()->findAllByPk($etIds) as $eventType) {
        $eventType->delete();
      }
    }
    unset(
      $data['idEventTypeRecover'],
      $data['idEventSubscriberRecover'],
      $data['idEventTypeRegister']
    );
    
    //удаляем виджет авторизации
    $data = $this->deleteSiteModule($data['id_widget_authorize'], $data, 'widget_authorize_place');
    unset($data['id_widget_authorize']);
    
    $data['cabinetEnabled'] = false;
    $plugin->setData($data);
    $trans->commit();
  }
  private function setupEventRegister() {
    $eventType = $this->prepareEventType('Регистрация нового пользователя');
    $eventType->save();
    return array('idEventTypeRegister' => $eventType->primaryKey);
  }
  public function updatePlugin(Plugin $plugin) {
    $data = $plugin->getData();
    if ($plugin->getIsEnabled()) {
      $data = array_merge($data, $this->setupEventRegister());
    }
    $plugin->setData($data);
  }
}