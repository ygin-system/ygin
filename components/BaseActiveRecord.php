<?php

abstract class BaseActiveRecord extends CActiveRecord {
  /**
   * Значение TRUE для булевой колонки
   * @var integer
   */
  const TRUE_VALUE = 1;
  /**
   * Значение FALSE для булевой колонки
   * @var integer
   */
  const FALSE_VALUE = 0;
  
  private static $_isStart = false;

  /**
   * @static
   * @param $model CActiveRecord
   * @return mixed
   */
  private static function processModelRelation($model) {
    $models = isset(Yii::app()->models) ? Yii::app()->models : array();
    $md = $model->getMetaData();
    $relations = $md->relations;
    foreach($relations AS $name => $relationClass) {
      if (isset($models[$relationClass->className])) {
        $className = Yii::import($models[$relationClass->className], false);
        $relationClass->className = $className;
        $md->relations[$name] = $relationClass;
      }
    }
    return $model;
  }

  public static function model($className=__CLASS__) {
    $models = isset(Yii::app()->models) ? Yii::app()->models : array();
    $className = HArray::val($models, $className, $className);
    $className = Yii::import($className, true);
    $model = parent::model($className);
    // такая обработка будет сделана только в случае когда ::model вызывается первый раз (вызов будет сделан в конструкторе).
    if (self::$_isStart) $model = self::processModelRelation($model);
    return $model;
  }
  public static function newModel($modelName, $scenario='insert') {
    $models = isset(Yii::app()->models) ? Yii::app()->models : array();
    $className = HArray::val($models, $modelName, $modelName);
    $className = Yii::import($className , true);
    return new $className($scenario);
  }

  public function __construct($scenario='insert') {
    parent::__construct($scenario);
    if (!self::$_isStart) {
      self::$_isStart = true;
      self::processModelRelation($this);
      self::$_isStart = false;
    }
  }

  public function addValidator(CValidator $validator) {
    $this->getValidatorList()->add($validator);
  }
  
}
