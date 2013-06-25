<?php

class BackendSort extends CSort {

  private $_model;

  public function getModel() {
    if ($this->_model == null) {
      $this->_model = CActiveRecord::model($this->modelClass);
    }
    return $this->_model;
  }
  public function setModel($model) {
    $this->_model = $model;
  }

  public function getOrderBy($criteria=null)
  {
    $directions=$this->getDirections();
    if(empty($directions))
      return is_string($this->defaultOrder) ? $this->defaultOrder : '';
    else
    {
      if($this->modelClass!==null)
        $schema=$this->model->getDbConnection()->getSchema();
      $orders=array();
      foreach($directions as $attribute=>$descending)
      {
        $definition=$this->resolveAttribute($attribute);
        if(is_array($definition))
        {
          if($descending)
            $orders[]=isset($definition['desc']) ? $definition['desc'] : $attribute.' DESC';
          else
            $orders[]=isset($definition['asc']) ? $definition['asc'] : $attribute;
        }
        else if($definition!==false)
        {
          $attribute=$definition;
          if(isset($schema))
          {
            if(($pos=strpos($attribute,'.'))!==false)
              $attribute=$schema->quoteTableName(substr($attribute,0,$pos)).'.'.$schema->quoteColumnName(substr($attribute,$pos+1));
            else
              $attribute=($criteria===null || $criteria->alias===null ? $this->model->getTableAlias(true) : $criteria->alias).'.'.$schema->quoteColumnName($attribute);
          }
          $orders[]=$descending?$attribute.' DESC':$attribute;
        }
      }
      return implode(', ',$orders);
    }
  }

}
