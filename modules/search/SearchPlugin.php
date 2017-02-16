<?php

class SearchPlugin extends PluginAbstract {
	public static function createPlugin(array $config) {
    return new SearchPlugin();
  }

	public function getName() {
    return 'Поиск по сайту';
  }
  public function getVersion() {
	  return '1.1';
  }
  public function getVersionDate() {
	  return '09.04.2014'; // формат?
  }
  public function getShortDescription() {
    return 'Поиск по любой информации на сайте.';
  }
  public function getDescription() {
    return 'Плагин позволяет гибко осуществлять поиск, настраивая индексируемые данные. Данные попадают в поисковый индекс сразу после внесения изменения или создания.';
  }

	public function getParametersValueFromConfig($config, $data) {
    if (isset($config['modules']['ygin.search'])) return $config['modules']['ygin.search'];
    return array();
  }
  public function getSettingsOfParameters() {
    return array();
  }
  public function getConfigByParamsValue(array $paramsValue, $data) {
    return array('modules' => array('ygin.search' => $paramsValue));
  }

	public function activate (Plugin $plugin){
		$this->createPermission (91,'Просмотр данных объекта Поисковый индекс','dev');
		$this->updateMenu = true;
	}

	public function deactivate (Plugin $plugin){
		Yii::app ()->authManager->removeAuthItemObject ('list',91);
		$this->updateMenu = true;
	}
}