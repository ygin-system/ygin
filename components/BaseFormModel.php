<?php

abstract class BaseFormModel extends CFormModel {

  public static function newModel($modelName, $scenario='insert') {
    $models = isset(Yii::app()->models) ? Yii::app()->models : array();
    $className = HArray::val($models, $modelName, $modelName);
    $className = Yii::import($className , true);
    return new $className($scenario);
  }
  
}
