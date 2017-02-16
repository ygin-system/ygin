<?php

Yii::import('backend.widgets.dropDownList.DropDownListWidget', true);

class DropDownObjectWidget extends DropDownListWidget {

  private $_init = false;
  private $_count = null;
  private $_object_ = null;

  public function init() {
    parent::init();
    $this->model->addValidator(CValidator::createValidator('length', $this->model, $this->attributeName, array('on'=>'backendInsert, backendUpdate', 'max'=>255)));
  }

  /**
   * @return DaObject
   */
  private function getObjectOfParameter() {
    if ($this->_object_ !== null) return $this->_object_;
    $this->_object_ = DaObject::getById($this->getObjectParameter()->getAdditionalParameter());
    return $this->_object_;
  }
  public function getIdObject() {
    return $this->getObjectOfParameter()->id_object;
  }

  public function getValueString() {
    $idInstance = $this->getValue();
    if ($idInstance == null) return null;
    $object = $this->getObjectOfParameter();
    $model = $object->getModel()->findByIdInstance($idInstance);
    return $model->getInstanceCaption();
  }

  public function getCountData() {
    if ($this->_count !== null) return $this->_count;
    $where = $this->getObjectParameter()->getSqlParameter();
    $cr = new CDbCriteria();
    if ($where != null) {
      $cr->addCondition($where);
      if (mb_strpos($where, ':id_instance') !== false) {
        $cr->params[':id_instance'] = $this->model->getIdInstance();
      }
    }
    $this->_count = $this->getObjectOfParameter()->getModel()->count($cr);
    return $this->_count;
  }

  private function processArray($allChildes, $idParent, $name, $level) {
    if ($level > 1) {
      $name = "|→ ".$name;
      $name = str_repeat('|--', ($level-2)).$name;
    }
    $data = array($idParent => $name);
    // Обработка child
    if (isset($allChildes[$idParent])) {
      foreach($allChildes[$idParent] AS $model) {
        $data = $data + $this->processArray($allChildes, $model->getIdInstance(), $model->getInstanceCaption(), $level+1);
      }
    }
    return $data;
  }

  public function getData() {
    if ($this->_init) return $this->_data;
    $this->_init = true;

    if ($this->canNull()) $this->htmlOption['prompt'] = '';

    $object = $this->getObjectOfParameter();
    $where = $this->getObjectParameter()->getSqlParameter();
    $cr = new CDbCriteria();
    if ($where != null) {
      $cr->addCondition($where);
      if (mb_strpos($where, ':id_instance') !== false) {
        $cr->params[':id_instance'] = $this->model->getIdInstance();
      }
    }
    $cr->limit = $this->maxData;
    $cr->order = $object->getOrderBy();
    $data = $object->getModel()->findAll($cr);

    $attributeName = $object->getFieldByType(DataType::ID_PARENT);

    $res = array();   // Результат, формата [id, level]
    $childes = array();
    foreach($data AS $model) {
      /**
       * @var $model DaActiveRecord
       */
      $curIdInst  = $model->getIdInstance();
      $curIdInstP = ($attributeName == null ? null : $model->$attributeName);
      if (is_null($curIdInstP)) {
        $res[$curIdInst] = $model->getInstanceCaption();
      } else {
        if (isset($childes[$curIdInstP])) $childes[$curIdInstP][] = $model; else $childes[$curIdInstP] = array($model);
      }
    }

    $options = array();
    if (count($res) > 0) {
      foreach($res as $idInstance => $caption) {
        $options = $options + $this->processArray($childes, $idInstance, $caption, 1);
      }
    } else {  // Если нет корневых элементов. Т.е. все элементы подвешены. Выводим их "в ряд".
      foreach($data AS $model) {
        $options = $options + $this->processArray(array(), $model->getIdInstance(), $model->getInstanceCaption(), 1);
      }
    }

    $this->_data = $options;
    return $this->_data;
  }

}
