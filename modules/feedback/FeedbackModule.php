<?php

class FeedbackModule extends DaWebModuleAbstract {
  
  const ROUTE_FEEDBACK = 'feedback/feedback';
  const ROUTE_FEEDBACK_CAPTCHA = '/feedback/feedback/captcha';
  
  public $idEventType;
  
  protected $_urlRules = array(
    'feedback' => self::ROUTE_FEEDBACK,
  );

  public function init() {
    $this->setImport(array(
      'feedback.models.*',
      'feedback.components.*',
      'feedback.views.*',
    ));
  }

}
