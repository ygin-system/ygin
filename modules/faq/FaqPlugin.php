<?php

class FaqPlugin extends PluginAbstract {

  public static function createPlugin(array $config) {
    return new FaqPlugin();
  }

  public function getName() {
    return 'Вопрос-ответ';
  }
  public function getVersion() {
    return '1.0';
  }
  public function getVersionDate() {
    return '22.08.2012'; // формат?
  }
  public function getShortDescription() {
    return 'Позволяет организовать обмен вопросов-ответов с пользователями сайта.';
  }

  public function getParametersValueFromConfig($config, $data) {
    if (isset($config['modules']['ygin.faq'])) {
      $params = $config['modules']['ygin.faq'];
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
    return array('modules' => array('ygin.faq' => $paramsValue));
  }
  public function getSettingsOfParameters() {
    return array(
        'pageSize' => array(
            'type' => DataType::INT,
            'default' => 15,
            'label' => 'Вопросов на одной странице',
            'description' => null,
            'required' => true,
        ),
        'moderate' => array(
            'type' => DataType::BOOLEAN,
            'default' => true,
            'label' => 'Предмодерация',
            'description' => 'Вопрос сперва попадает на проверку редактору сайта',
            'required' => false,
        ),
        'sendMail' => array(
            'type' => DataType::BOOLEAN,
            'default' => false,
            'label' => 'Отправлять ответы на e-mail',
            'description' => null,
            'required' => false,
        ),
        'useCategories' => array(
            'type' => DataType::BOOLEAN,
            'default' => false,
            'label' => 'Использовать категории',
            'description' => null,
            'required' => false,
        ),
        'idEventTypeAnswer' => array(
            'type' => DataType::INT,
            'default' => null,
            'label' => 'ИД типа события для ответа',
            'description' => null,
            'required' => false,
        ),
        'idEventSubscriberAnswer' => array(
            'type' => DataType::INT,
            'default' => null,
            'label' => 'ИД подписчика для ответа',
            'description' => null,
            'required' => false,
        ),
    );
  }

  public function install(Plugin $plugin) {
    $plugin->setData(array(
        'id_object' => 512,
    ));
  }
  public function activate(Plugin $plugin) {
    $data = $plugin->getData();
    if ($data === null) $data = array();
    if (isset($data['id_menu']) && is_numeric($data['id_menu'])) { // не должно быть такого
      return;
    }
    if (Menu::model()->exists('id=:id', array(':id'=>108))) {
      // на сайте изначально был установлен данный плагин.
      // записываем данные по умолчанию
      $data['id_menu'] = 108;
      $data['id_event_type'] = 103;
    } else {

      $eventType = $this->prepareEventType('Вопрос-ответ » Новый вопрос');
      $eventType->save();
      $data['id_event_type'] = $eventType->id_event_type;

      // создаем раздел меню
      $menu = $this->prepareMenu(
              'Вопрос-ответ',
              'Вопрос-ответ',
              'faq',
              '/faq/',
              (isset($data['id_menu_module_template']) ? $data['id_menu_module_template'] : null)
      );
      $menu->save();
      $data['id_menu'] = $menu->id;

      $this->createPermission($data['id_object'], 'Просмотр списка данных объекта Вопрос-ответ');

      $this->updateMenu = true;
    }
    $plugin->setData($data);
    $plugin->setConfig($this->getConfigByParamsValue($plugin->getParamsValue(), $data));
  }

  public function deactivate(Plugin $plugin) {
    $data = $plugin->getData();
    if ($data === null || !isset($data['id_menu'])) {
      throw new ErrorException('Плагин установлен неверно.');
    }

    $data = $this->deleteMenu($data['id_menu'], $data, 'id_menu_module_template');

    // Удаляем: все отправленные и неотправленные события по типу события + подписчиков + тип события
    $eventType = NotifierEventType::model()->findByPk($data['id_event_type']);
    if ($eventType != null) {
      $eventType->delete();
    }

    Yii::app()->authManager->removeAuthItemObject('list', $data['id_object']);
    $this->updateMenu = true;

    unset($data['id_menu'], $data['id_event_type']);

    $plugin->setData($data);
  }

}