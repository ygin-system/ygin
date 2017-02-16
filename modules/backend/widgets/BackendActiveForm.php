<?php
class BackendActiveForm extends CActiveForm {
  public $errorMessageCssClass = 'label label-danger label-message';
  public $requiredCssClass     = 'required';

  public function error($model,$attribute,$htmlOptions=array(),$enableAjaxValidation=true,$enableClientValidation=true) {
    $html = '<br class="error-breaker">'.parent::error($model,$attribute,$htmlOptions,$enableAjaxValidation,$enableClientValidation);
    return $html;
  }

  public function textField($model,$attribute,$htmlOptions=array()) {
    if ($model->isAttributeRequired($attribute)) {
      $htmlOptions['required'] = 'required';
    }
    return parent::textField($model,$attribute,$htmlOptions);
  }

  public function textArea($model,$attribute,$htmlOptions=array()) {
    if ($model->isAttributeRequired($attribute)) {
      $htmlOptions['required'] = 'required';
    }
    return parent::textArea($model,$attribute,$htmlOptions);
  }
  public function checkBox($model,$attribute,$htmlOptions=array()) {
    if ($model->isAttributeRequired($attribute)) {
      $htmlOptions['required'] = 'required';
    }
    return parent::checkBox($model,$attribute,$htmlOptions);
  }
  public function dropDownList($model,$attribute,$data,$htmlOptions=array()) {
    if ($model->isAttributeRequired($attribute)) {
      $htmlOptions['required'] = 'required';
    }
    return parent::dropDownList($model,$attribute,$data,$htmlOptions);
  }
}