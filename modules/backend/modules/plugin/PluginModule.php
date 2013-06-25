<?php

class PluginModule extends DaWebModuleAbstract {

  const ROUTE_PLUGIN_LIST = 'backend/plugin/plugin';
  const ROUTE_PLUGIN_VIEW = 'backend/plugin/plugin/view';

  public $urlRules = array(
    // TODO пока тут прописываем все маршруты объектов-контроллеров. Позже их необходимо будет отсюда убрать и что-то для них придумать
    'plugins' => self::ROUTE_PLUGIN_LIST,
    'plugins/<code:[\w\W\.]+>/' => self::ROUTE_PLUGIN_VIEW,
  );

  public function init() {
    $this->setImport(array(
        'plugin.components.*',
        'ygin.modules.menu.models.*',
        'plugin.models.*',
    ));
  }

  public static function updateByCode($code) {
    Yii::import('ygin.modules.backend.modules.plugin.components.*');
    Yii::import('ygin.modules.backend.modules.plugin.models.*');
    Yii::import('ygin.models.*');
    $plugin = Plugin::loadByCode($code);
    if ($plugin == null) return;
    $plugin->updatePlugin($plugin);
    $plugin->save();
    @unlink(Yii::app()->getRuntimePath().'/plugin-compile.dat');
  }

}
