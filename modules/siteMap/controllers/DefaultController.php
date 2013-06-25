<?php
class Defaultcontroller extends DaFrontendController {
  protected $urlAlias = 'siteMap';
  
  public function actionIndex() {
    $this->render('/siteMap', array('tree' => Menu::model()->getTree()));
  }
}