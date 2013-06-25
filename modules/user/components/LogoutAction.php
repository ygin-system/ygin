<?php
class LogoutAction extends CAction {
  public function run() {
    if (Yii::app()->isBackend) Yii::app()->user->returnUrl = Yii::app()->homeUrl;
    $returnUrl = Yii::app()->user->returnUrl;
    Yii::app()->user->logout();
    $this->controller->redirect($returnUrl);
  }
}