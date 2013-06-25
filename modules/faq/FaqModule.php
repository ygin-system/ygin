<?php

class FaqModule extends DaWebModuleAbstract {

  public $pageSize = 20;
  public $moderate = false;
  public $sendMail = false;
  
  public $idEventType;
  
  protected $_urlRules = array(
    'faq' => 'faq/default/index',
  );

  public function init() {
    $this->setImport(array(
      'faq.models.*',
      'faq.components.*',
    ));
  }

}
