<?php

class ConfigureDataProviderEvent extends CEvent {

  public $idObjectView;
  public $dataProvider;

  public function __construct($sender, $idView, $dataProvider) {
    parent::__construct($sender);

    $this->idObjectView = $idView;
    $this->dataProvider = $dataProvider;
  }
}
