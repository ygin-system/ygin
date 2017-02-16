<?php

class CheckBoxWidget extends VisualElementWidget {

  public $autoRequiredValidator = false;
  public $label = null;

  public function init() {
    parent::init();
    $this->model->addValidator(CValidator::createValidator('boolean', $this->model, $this->attributeName, array('on' => 'backendInsert, backendUpdate')));
  }

}
