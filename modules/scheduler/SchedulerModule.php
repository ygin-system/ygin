<?php
class SchedulerModule extends DaWebModuleAbstract {
  public function init() {
    $this->setImport(array(
      $this->getId().'.models.*',
      $this->getId().'.components.*',
    ));
    if (Yii::app() instanceof CConsoleApplication) {
      Yii::app()->commandRunner->addCommands(realpath(dirname(__FILE__).'/commands'));
    }
  }
}