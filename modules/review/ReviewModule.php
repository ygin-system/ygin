<?php

class ReviewModule extends DaWebModuleAbstract {

  public $pageSize = 20;
  public $moderate = false;
  
  public $idEventType;
  
  protected $_urlRules = array(
    'review' => 'review/default/index',
  );
  
  public function init() {
    $this->setImport(array(
      'review.models.*',
      'review.components.*',
    ));
  }

}
