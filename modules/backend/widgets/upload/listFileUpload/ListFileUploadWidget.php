<?php
Yii::import('backend.widgets.upload.BackendBaseUploadWidget');
class ListFileUploadWidget extends BackendBaseUploadWidget {
  public function init() {
    parent::init();
    $cs = Yii::app()->clientScript;
    $cs->registerScriptFile(CHtml::asset(dirname(__FILE__).'/../assets/BackendUploadedFiles.js'));
  }
}