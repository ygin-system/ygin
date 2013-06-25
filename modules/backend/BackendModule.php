<?php

Yii::import('backend.interface.IBackendExtension');

class BackendModule extends DaWebModuleAbstract implements IApplicationComponent { //IBackendExtension

  const CATEGORY_BACKEND_WINDOW = 'backend.window';
  const EVENT_ON_BEFORE_TOP_MENU = 'onBeforeTopMenu';
  const EVENT_ON_BEFORE_USER_MENU = 'onBeforeUserMenu';
  const EVENT_ON_BEFORE_MAIN_MENU = 'onBeforeMainMenu';
  
  const ROUTE_INSTANCE_LIST = 'backend/default/index';
  const ROUTE_INSTANCE_LIST_GROUP = 'backend/default/indexGroup';
  const ROUTE_INSTANCE_VIEW = 'backend/view/index';
  
  public $modules = array(
    'ygin.plugin',
    'ygin.transfer',
  );
  
  public $urlRules = array(
    array(
        'class' => 'backend.components.ObjectUrlRule',
    ),
  );

  public $rightTopWidget = 'RightTopWidget';
  public $topMenuWidget = 'zii.widgets.CMenu';
  public $userMenuWidget = 'zii.widgets.CMenu';
  public $mainMenuWidget = 'MainMenuWidget';
  
  public $objectView = null;
  public $object = null;
  
  private $_extensions = array();
  public $autoExtensionDir = array();
  
  private $_initExt = array();
  
  
  
  public function init() {
    $this->setImport(array(
      'backend.models.*',
      'backend.components.*',
      'backend.components.event.*',
      'backend.interface.*',

      'backend.widgets.*',
      'backend.widgets.hiddenField.HiddenFieldWidget',
      'backend.widgets.textField.TextFieldWidget',
      'backend.widgets.checkBox.CheckBoxWidget',
      'backend.widgets.textarea.TextareaWidget',
      'backend.widgets.tinymce.TinymceWidget',
      'backend.widgets.dropDownList.*',
      'backend.widgets.dateTime.DateTimeWidget',
      'backend.widgets.upload.singleFileUpload.SingleFileUploadWidget',
      'backend.widgets.upload.listFileUpload.ListFileUploadWidget',
    ));
    
    $ass = Yii::getPathOfAlias('backend.assets.css.jquery-ui.images').DIRECTORY_SEPARATOR;
    Yii::app()->clientScript->addDependResource('jquery-ui.custom.min.css', array(
      $ass.'pbar-ani.gif' => './images/',
      $ass.'ui-bg_diagonals-thick_90_eeeeee_40x40.png' => 'images/',
      $ass.'ui-bg_flat_15_cd0a0a_40x100.png' => 'images/',
      $ass.'ui-bg_glass_100_c5c9cb_1x400.png' => 'images/',
      $ass.'ui-bg_glass_100_eaeaea_1x400.png' => 'images/',
      $ass.'ui-bg_glass_80_000000_1x400.png' => 'images/',
      $ass.'ui-bg_gloss-wave_50_18359d_500x100.png' => 'images/',
      $ass.'ui-bg_highlight-hard_100_f2f5f7_1x100.png' => 'images/',
      $ass.'ui-bg_highlight-hard_70_000000_1x100.png' => 'images/',
      $ass.'ui-bg_highlight-soft_25_ffef8f_1x100.png' => 'images/',
      $ass.'ui-icons_000000_256x240.png' => 'images/',
      $ass.'ui-icons_2e83ff_256x240.png' => 'images/',
      $ass.'ui-icons_ffffff_256x240.png' => 'images/',
    ));
    
    Yii::app()->setComponent('backend', $this);
    
    // инициализацию проводим тут, т.к. надо добавить в приложение правила обработки урлов
    
    // папки с расширениями, которые автоматически подключаем к модулю
    array_unshift($this->autoExtensionDir, 'backend.extensions');

    foreach ($this->autoExtensionDir AS $dir) {
      if (strpos($dir, '/') === false)
        $dir = Yii::getPathOfAlias($dir);
      $files = HFile::findFiles($dir, array('level' => 1));
      foreach ($files AS $f) {
        if (basename($f) != 'config.php')
          continue;
        $extName = str_replace('config.php', '', str_replace($dir, '', $f));
        $extName = trim($extName, DIRECTORY_SEPARATOR);
        if ($extName == '') continue;
        $this->extensions = array($extName => require $f);
      }
    }
    // подключение расширений, зарегистрированных в базе
    // TODO
    // 
    
    //$this->addExtension($this);
    
    // TODO - кэшить настройки расширений
    
    foreach($this->_extensions AS $ext) {
      if (!is_array($ext)) continue;
      if (isset($ext['rules'])) {
        Yii::app()->urlManager->addRules($ext['rules'], false);
        if (isset($ext['application']['controllerMap'])) {
          Yii::app()->controllerMap = CMap::mergeArray(Yii::app()->controllerMap, $ext['application']['controllerMap']);
          unset($ext['application']['controllerMap']);
        }
      }
      if (isset($ext['application'])) {
        foreach($ext['application'] AS $param => $value) {
          Yii::app()->$param = $value;
        }
      }
    }
  }
  
  public function raiseEvent($name, $event) {
    if ($event == null) $event = new CEvent();
    $this->initExtension(self::CATEGORY_BACKEND_WINDOW); // регистрация всех расширений на категорию событий
    parent::raiseEvent($name, $event);
  }
  
  public function addExtension(IBackendExtension $extension) {
    $this->_extensions[] = $extension;
  }
  public function setExtensions($extensions) {
    if (is_object($extensions)) throw new Exception("Type of extensions must be array or string");
    if ($extensions == null) return;
    if (is_string($extensions)) $this->_extensions[] = $extensions;
      else if (is_array($extensions)) $this->_extensions = CMap::mergeArray($this->_extensions, $extensions);
  }
  
  public function initExtension($category) {
    if (in_array($category, $this->_initExt)) return;
    foreach($this->_extensions AS $name => $params) {
      if (is_int($name)) {
        $name = $params;
        $params = array();
      }
      if (is_object($name)) {
        $name->registerEvent($category, $this);
        continue;
      }
      if (isset($params['enabled']) && !$params['enabled']) continue;
      if (!isset($params['category'])) continue;
      $categories = explode(',', $params['category']);
      
      foreach ($categories AS $cat) {
        if (trim($cat) == $category) {
          if (!isset($params['class'])) $params['class'] = $name;
          unset($params['category'], $params['enabled'], $params['controllerMap'], $params['rules'], $params['application']);
          $ext = Yii::createComponent($params, null, null, null);
          if ($ext instanceof IBackendExtension) $ext->registerEvent($category, $this);
          break;
        }
      }
    }
    $this->_initExt[] = $category;
  }
  
  
  public function hasEvent($name) {
    return true;
  }
  public function getIsInitialized() {
    return true;
  }
  
  
  /*
  // реализация события класса как компонента
  public function registerEvent($category, $obj) {
    if ($category == BackendModule::CATEGORY_BACKEND_WINDOW) {
      $obj->attachEventHandler(BackendModule::EVENT_ON_BEFORE_TOP_MENU, array($this, 'onBeforeTopMenu'));
    }
  }

  public function onBeforeTopMenu($event) {
    $sender = $event->sender;
    
    $name = (Yii::app()->user->model->full_name == null) ? Yii::app()->user->model->name : Yii::app()->user->model->full_name;
    
    $sender->items[] = array(
      'label' => 'Выход ['.$name.']',
      'url' => Yii::app()->createUrl(UserModule::ROUTE_LOGOUT),
      'template' => '{menu}',
      'active' => false,
    );
  }
*/

}
