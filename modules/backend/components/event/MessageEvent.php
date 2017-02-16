<?php

class MessageEvent extends CEvent {

  public $message;
  public $type;
  public $sticked;
  public $time;

  public function __construct($sender, $message, $type, $sticked, $time) {
    parent::__construct($sender);
    $this->message = $message;
    $this->type = $type;
    $this->sticked = $sticked;
    $this->time = $time;
  }

}
