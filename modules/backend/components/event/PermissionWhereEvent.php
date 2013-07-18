<?php

class PermissionWhereEvent extends CEvent {

  public $idObject;
  public $where;
  public $params = array();

  public function __construct($sender, $idObject, $where, $params=array()) {
    parent::__construct($sender);

    $this->idObject = $idObject;
    $this->where = $where;
    $this->params = $params;
  }
}
