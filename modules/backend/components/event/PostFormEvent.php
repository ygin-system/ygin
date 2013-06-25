<?php

class PostFormEvent extends CEvent {

  public $model;

  public function __construct($sender, $model) {
    parent::__construct($sender);

    $this->model = $model;
  }
}
