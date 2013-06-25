<?php

class DaInstance extends DynamicActiveRecord {

  public static function forObject(DaObject $object, $scenario = 'insert') {
    $model = new DaInstance($scenario, $object->table_name);
    $model->setObjectInstance($object);
    return $model;
  }
  
  protected function instantiate($attributes) {
    $class = get_class($this);
    $result = new $class(null, $this->tableName());
    $result->setObjectInstance($this->getObjectInstance());
    return $result;
  }

}