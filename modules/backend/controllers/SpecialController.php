<?php

class SpecialController extends DaObjectController {

  public function actionSql() {
    $this->render('sql', array(
    ));
  }

  public function actionClearCache() {
    $this->render('clearCache', array(
    ));
  }
  public function actionClearPreview() {
    $this->render('clearPreview', array(
    ));
  }

  public function actionLogView() {
    $this->render('logView', array(
    ));
  }
  public function actionRecreateSearchIndex() {
    $this->render('recreateSearchIndex', array(
    ));
  }



}