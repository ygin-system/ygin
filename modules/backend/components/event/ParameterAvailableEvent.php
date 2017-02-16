<?php

class ParameterAvailableEvent extends CEvent {

  public $model;
  /**
   * @var ObjectParameter
   */
  public $objectParameter;
  public $status;

  public function __construct($sender, $model, $objectParameter, $status = ViewController::ENTITY_STATUS_AVAILABLE) {
    parent::__construct($sender);

    $this->model = $model;
    $this->objectParameter = $objectParameter;
    $this->status = $status;
  }
}
