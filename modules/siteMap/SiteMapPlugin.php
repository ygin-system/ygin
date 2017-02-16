<?php
Yii::import('ygin.modules.siteMap.SiteMapModule');

class SiteMapPlugin extends PluginAbstract {
  public static function createPlugin(array $config) {
    return new self();
  }
  public function getName() {
    return 'Карта сайта';
  }
  public function getVersion() {
    return '0.1';
  }
  public function getVersionDate() {
    return '10.10.2012';
  }
  public function getShortDescription() {
    return 'Предоставляет возможность пользователям видеть полностью структуру сайта и перемещаться по ней.';
  }
  public function getConfigByParamsValue(array $paramsValue, $data) {
    return array('modules' => array('ygin.siteMap'));
  }
  public function activate(Plugin $plugin) {
    $data = $plugin->getData();
    $data = $data === null ? array() : $data;
    $menu = $this->prepareMenu('Карта сайта', 'Карта сайта', 'siteMap', '/map/');
    $menu->save();
    $data['idMenu'] = $menu->primaryKey;
    $plugin->setData($data);
  }
  
  public function deactivate(Plugin $plugin) {
    $data = $plugin->getData();
    if ($data === null || !isset($data['idMenu'])) {
      throw new ErrorException('Плагин установлен неверно.');
    }
    $data = $this->deleteMenu($data['idMenu'], $data);
    unset($data['idMenu']);
    $plugin->setData($data);
  }
}