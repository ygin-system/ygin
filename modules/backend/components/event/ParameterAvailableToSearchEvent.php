<?php

class ParameterAvailableToSearchEvent extends CEvent {

  public $objectParameter;
  public $visible;

  public function __construct($sender, $objectParameter, $visible = true) {
    parent::__construct($sender);

    $this->objectParameter = $objectParameter;
    $this->visible = $visible;
  }
}
