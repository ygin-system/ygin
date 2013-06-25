<?php

Yii::import('ygin.widgets.vitrine.models.Vitrine');

class VitrineWidget extends DaWidget {
  
  public function run() {
    $models = Vitrine::model()->findAll();
    $this->render("view", array("models" => $models) );
  }
  
}