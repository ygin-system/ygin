<?php

class BeforeGridEvent extends CEvent {

  public $idObjectView;
  public $grid;

  public function __construct($sender, $idView, $grid) {
    parent::__construct($sender);

    $this->idObjectView = $idView;
    $this->grid = $grid;
  }
}
