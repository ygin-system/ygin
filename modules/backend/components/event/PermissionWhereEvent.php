<?php

class PermissionWhereEvent extends CEvent {

  public $idObject;
  public $where;

  public function __construct($sender, $idObject, $where) {
    parent::__construct($sender);

    $this->idObject = $idObject;
    $this->where = $where;
  }
}
