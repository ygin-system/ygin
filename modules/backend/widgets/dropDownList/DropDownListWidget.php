<?php

class DropDownListWidget extends VisualElementWidget {

  protected $_data = array();
  public $htmlOption = array('class' => 'form-control');

  public $maxData = 1000;

  public function getData() {
    return $this->_data;
  }
  public function getCountData() {
    return count($this->getData());
  }
  public function getValue() {
    $attr = $this->attributeName;
    return $this->model->$attr;
  }
  public function getValueString() {
    return null;
  }
  public function getIdObject() {
    return $this->model->getIdObject();
  }

  //public $readOnlyView = 'backend.widgets.dropDownList.views.readOnly';

}
