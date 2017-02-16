<?php

class CreateInstanceEvent extends CEvent {

  public $idObject;
  public $create;

  public function __construct($sender, $idObject, $create=true) {
    parent::__construct($sender);

    $this->idObject = $idObject;
    $this->create = $create;
  }
}
