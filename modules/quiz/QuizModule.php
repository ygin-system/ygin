<?php

class QuizModule extends DaWebModuleAbstract {

  protected $_urlRules = array(
    'quiz/<id:\d+>' => 'quiz/default/view',
  );
  
  public function init() {
    $this->setImport(array(
      $this->getId() . '.models.*',
      $this->getId() . '.forms.*',
    ));
  }

  public static function getDefaultConfig() {
    return array('modules' => array('ygin.quiz'));
  }

}