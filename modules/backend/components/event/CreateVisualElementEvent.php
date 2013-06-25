<?php

class CreateVisualElementEvent extends CEvent {

  public $visualElement;
  public $model;
  public $objectParameter;

  public function __construct($sender, $model, $objectParameter) {
    parent::__construct($sender);

    $this->visualElement = null;
    $this->model = $model;
    $this->objectParameter = $objectParameter;
  }
}
