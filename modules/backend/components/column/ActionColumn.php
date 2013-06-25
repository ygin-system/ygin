<?php

class ActionColumn extends CGridColumn {

  private $_object = null;
  private $_init = false;

  public function setObject($object) {
    $this->_object = $object;

    // чтоб скрыть видимость в случае отсутствия действий
    if (!$this->_init) {
      $this->initColumn();
      $this->_init = true;
    }
  }
  public function getObject() {
    return $this->_object;
  }
  protected function initColumn() {
  }



}
