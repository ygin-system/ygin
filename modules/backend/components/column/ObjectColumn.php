<?php

class ObjectColumn extends BaseColumn {

  private $_assocData = array();

  public function init() {
    if ($this->objectParameter == null) {
      throw new Exception("Не указан параметр объекта у колонки с типом Объект");
    }
    $data = $this->grid->dataProvider->getData();
    $field = $this->name;
    foreach($data AS $row) {
      $val = $row[$field];
      if ($val != null && !in_array($val, $this->_assocData)) {
        $this->_assocData[] = $row[$field];
      }
//      $this->_assocData[$row[$field]] = $row[$field];
    }
    $idObject = $this->objectParameter->getAdditionalParameter();
    $object = DaObject::getById($idObject, false);
    $model = $object->getModel();
    //$rows = $model->findAllByPkArray($this->_assocData);
    $rows = $model->findAllByAttributes(array($object->getFieldByType(DataType::PRIMARY_KEY)=>$this->_assocData));
    $this->_assocData = array();
    foreach($rows AS $model) {
      $this->_assocData[$model->getIdInstance()] = $model->getInstanceCaption();
    }
  }
  protected function renderDataCellContent($row, $data) {
    $field = $this->name;
    $id = $data->$field;
    echo (isset($this->_assocData[$id]) ? $this->_assocData[$id] : '');
  }

}
