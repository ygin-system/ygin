<?php
Yii::import('backend.widgets.upload.BackendBaseUploadWidget');
class SingleFileUploadWidget extends BackendBaseUploadWidget {
  public function init() {
    parent::init();
    $cs = Yii::app()->clientScript;
    $cs->registerScriptFile(CHtml::asset(dirname(__FILE__).'/../assets/BackendUploadedFiles.js'));
    if ($this->getObjectParameter()->isRequired()) {
      $this->model->getValidatorList()->add(
        CValidator::createValidator(
          'required',
          $this->model,
          array($this->getObjectParameter()->getFieldName()), array('on' => 'backendInsert, backendUpdate')
      ));
    }
  }
}