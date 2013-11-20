<?php

class BlockWidget extends CWidget {
  
  public $place = null;
  private static $_modules = null;

  public function run() {
    if ($this->place === null)
      throw new ErrorException("Не задано место блока (BlockWidget).");

    $modules = null;
    if (Yii::app()->controller->idSiteModuleTemplate == null) { // если у контроллера не установлен свой набор виджетов
      if (Yii::app()->menu->current != null) {  // иначе берем набор модулей меню
        $modules = Yii::app()->menu->current->getModulesByPlace($this->place);
      } else {  // иначе пытаемся найти набор по умолчанию
        Yii::app()->controller->idSiteModuleTemplate = SiteModuleTemplate::getIdDefaultTemplate();
      }
    }

    if ($modules === null && Yii::app()->controller->idSiteModuleTemplate != null) {
      if (self::$_modules == null) {
        self::$_modules = SiteModule::model()->with(array(
          'place' => array('condition' => 'place.id_module_template=:id_template', 'params' => array('id_template' => Yii::app()->controller->idSiteModuleTemplate)),
          'phpScriptInstance.phpScript',
        ))->findAll();
      }
      $modules = array();
      foreach (self::$_modules AS $module) {
        if ($module->place->place == $this->place) $modules[] = $module;
      }
    } else if ($modules === null) {
      return;
    }

    foreach ($modules AS $module) {
      if ($module->id_php_script != null) { // динамический модуль
        // формируем массив с параметрами
        $params = array();
        $moduleParams = $module->phpScriptInstance->phpScript->getParametersConfig();
        foreach ($moduleParams AS $paramName => $config) {
          $params[$paramName] = $module->phpScriptInstance->getParameterValue($paramName);
        }
        $className = $module->phpScriptInstance->phpScript->import();
        $this->controller->widget($className, $params);
      } else {  // статика
        echo $module->content;
        echo $module->html;
      }
    }
  }

}