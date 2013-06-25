<?php

class BlockWidget extends CWidget {
  
  public $place = null;
  
  public function run() {
    if ($this->place === null)
      throw new ErrorException("Не задано место блока (DaBlockWidget).");

    // если нет раздела, то выходим
    if (Yii::app()->menu->current == null)
      return;

    $modules = Yii::app()->menu->current->getModulesByPlace($this->place);
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