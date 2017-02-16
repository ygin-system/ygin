<?php

class ReferenceColumn extends BaseColumn {

  public $htmlOptions = array('class'=>'col-ref');

  private $_assocData = array();

  public function init() {
    $data = $this->grid->dataProvider->getData();
    $field = $this->name;
    foreach($data AS $row) {
      $val = $row[$field];
      if ($val != null && !in_array($val, $this->_assocData)) {
        $this->_assocData[] = $row[$field];
      }
    }
    $idReference = $this->objectParameter->getAdditionalParameter();
    $rows = ReferenceElement::model()->byReference($idReference)->findAllByAttributes(array('id_reference_element'=>$this->_assocData));
    $this->_assocData = array();
    foreach($rows AS $model) {
      $this->_assocData[$model->getIdReferenceElement()] = $model->getValue();
    }
  }
  protected function renderDataCellContent($row, $data) {
    $field = $this->name;
    $id = $data->$field;
    echo (isset($this->_assocData[$id]) ? $this->_assocData[$id] : '');
  }

}
