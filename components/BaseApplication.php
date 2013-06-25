<?php

/**
 * BaseApplication
 *
 * The followings are the available component:
 * @property DaDomain $domain
 * @property DaMenu $menu
 */
abstract class BaseApplication extends CWebApplication {

  private $_plugins = array();
  public $pluginsCompile = false;
  private $_models = array();
  
  public $isBackend = false;
  public $isFrontend = false;

  private $isInit = false;
  
  private $_params = null;

  public $version = '0.92.3';
  public $versionDate = '25.06.2013';

  public function __construct($config = null) {
    parent::__construct($config);
    register_shutdown_function(array($this, 'onShutdownHandler'));
  }
  
  public function setModels(array $models) {
    $this->_models = array_merge($this->_models, $models);
  }
  public function getModels() {
    return $this->_models;
  }
  
  public function getParams() {
    if ($this->_params !== null)
      return $this->_params;
    else {
      $this->_params = new DaApplicationParameters();
      $this->_params->caseSensitive = true;
      return $this->_params;
    }
  }
  
  /**
   * Обработчик фатальных ошибок
   */
  public function onShutdownHandler() {
    //http://habrahabr.ru/post/136138/
    // 1. error_get_last() returns NULL if error handled via set_error_handler
    // 2. error_get_last() returns error even if error_reporting level less then error
    $e = error_get_last();

    $errorsToHandle = E_ERROR | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_COMPILE_WARNING;

    if (!is_null($e) && ($e['type'] & $errorsToHandle)) {
      $msg = 'Fatal error: ' . $e['message'];
      // it's better to set errorAction = null to use system view "error.php" instead of run another controller/action (less possibility of additional errors)
      Yii::app()->errorHandler->errorAction = null;
      // handling error
      Yii::app()->handleError($e['type'], $msg, $e['file'], $e['line']);
    }
  }

  public function compilePluginsConfig() {
    Yii::import('ygin.models.Plugin');
    $plugins = Plugin::model()->enabled()->findAll();
    $config = array('pluginsCompile' => true);
    foreach ($plugins AS $plugin) {
      $applPlugin = $this->getPluginConfig($plugin->code);
      $defaultConfig = (isset($applPlugin['defaultConfig']) ? $applPlugin['defaultConfig'] : array());
      $pluginConfig = ($plugin->config !== null ? $plugin->getConfig() : array());
      $config = CMap::mergeArray($config, $defaultConfig, $pluginConfig);
    }
    $path = $this->getRuntimePath().'/plugin-compile.dat';
    file_put_contents($path, serialize($config));
  }
  
  public function setPlugins($val) {
    $this->_plugins = $val;
  }
  public function getPlugins() {
    return $this->_plugins;
  }
  private function getPluginConfig($code) {
    if (isset($this->_plugins[$code])) {
      return $this->_plugins[$code];
    } else {
      return array();
    }
  }


  public function init() {
    parent::init();
    if ($this->isInit) return;

    $this->setImport(array(
      'ygin.models.object.*',
      'ygin.interface.*',
      'ygin.models.*',
      'ygin.widgets.*',
      'ygin.widgets.linkPager.LinkPagerWidget',
      'ygin.widgets.alert.AlertWidget',
      'ygin.behaviors.*',
      'ygin.controllers.*',
    ));

    $this->controllerMap['static'] = 'ygin.controllers.StaticController';

    mb_internal_encoding('UTF-8');
    mb_regex_encoding('UTF-8');

    // если ещё не был создан конфиг файл плагинов, то создаем его и перезагружаем страницу
    if ($this->isFrontend && !$this->pluginsCompile) {
      // сюда должны попадать в крайнем случае
      //throw new ErrorException('Системная ошибка, плагины системы не проинициализированы. Обратитесь к разработчикам.');
      $this->compilePluginsConfig();
      Yii::app()->getRequest()->redirect(Yii::app()->getRequest()->getUrl()); 
    }

    // добавление маршрутов модулей
    $modules = $this->getModules();

    $urlManager = $this->getUrlManager();
    //  print_r($modules);exit;
    $urlRules = array();
    foreach ($modules AS $moduleName => $params) {
      if ($moduleName == 'gii')
        continue;  // перекрывает errorHandler/errorAction
      $module = Yii::app()->getModule($moduleName);
      if (isset($module->urlRules) && count($module->urlRules) > 0) {
        //HU::dump($module->urlRules);
        $urlRules = array_merge($urlRules, $module->urlRules);
        //HU::dump($urlRules);
      }

      // получилось только так сделать ининициализацию вложенного модуля
      if (!empty($module->modules)) {
        $module->setModules($module->modules);
        $childModules = $module->getModules();
        foreach ($childModules AS $id => $config) {
          if (is_int($id)) {
            $id = $config;
          }
          $childModule = $module->getModule($id);
          if (isset($childModule->urlRules)) {
            $urlRules = array_merge($urlRules, $childModule->urlRules);
            //$urlManager->addRules(array_reverse($childModule->urlRules), false);
          }
        }
      }
    }
    //HU::dump($urlRules);exit;
    $urlManager->addRules($urlRules, false);
    //print_r($urlManager);exit;
    $this->isInit = true;
  }

  public function setModules($modules) {
    $newModules = array();
    foreach ($modules as $id => $module) {
      if (is_int($id)) {
        $id = $module;
        $module = array();
      }
      if (strpos($id, "ygin.") !== false) {
        $id = str_replace("ygin.", "", $id);
        if ($id != 'ygin')
          Yii::setPathOfAlias($id, Yii::getPathOfAlias('ygin.modules.' . $id));
        if (!isset($module['class'])) $module['class'] = $id . '.' . ucfirst($id) . 'Module';
      }
      $newModules[$id] = $module;
      if ($this->isInit && isset($module->urlRules) && count($module->urlRules) > 0) {
        $urlManager = $this->getUrlManager();
        $urlManager->addRules($module->urlRules, false);
      }
    }
    //HU::dump($this->getUrlManager());exit;
    //HU::dump($newModules);exit;
    parent::setModules($newModules);
  }
  public function addModule($moduleName) {
    $this->setModules(array($moduleName));
  }

}