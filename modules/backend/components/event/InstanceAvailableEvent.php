<?php

class InstanceAvailableEvent extends CEvent {

  public $model;
  public $status;

  public function __construct($sender, $model, $status = ViewController::ENTITY_STATUS_AVAILABLE) {
    parent::__construct($sender);

    $this->model = $model;
    $this->status = $status;
  }
}
