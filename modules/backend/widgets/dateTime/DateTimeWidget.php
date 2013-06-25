<?php
Yii::import('ygin.components.dateTime.*');
class DateTimeWidget extends VisualElementWidget {
  public function getIsTimeAvailable() {
    return $this->getObjectParameter()->add_parameter != BaseActiveRecord::TRUE_VALUE;
  }
  public function init() {
    parent::init();
    if (!$this->model->asa('DateTimeBehavior') instanceof DateTimeBehavior) {
      $this->model->attachBehavior('DateTimeBehavior', array(
        'class' => 'ygin.components.dateTime.DateTimeBehavior',
      ));
    }
    $objectParam = $this->getObjectParameter();
    
    $dateTimeForm = new DateTimeForm();
    $dateTimeForm->dateTimeAttribute = $objectParam->getFieldName();
    $dateTimeForm->isTimeAvailable = $this->getIsTimeAvailable();
    $dateTimeForm->owner = $this->model;
    if ($objectParam->isRequired()) {
      $dateTimeForm->required = true;
    }
    $this->model->addDateTimeForm($dateTimeForm);
  }
}