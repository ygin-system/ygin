<?php
class DateTimeBehavior extends CModelBehavior {
  private $_dateTimes = array();
  public $dateTimeFormClass = 'DateTimeForm';
  public function setDateTimes(array $dateTimeForms) {
    foreach ($dateTimeForms as $attribute => $formData) {
      if (isset($this->_dateTimes[$attribute], $formData[$this->dateTimeFormClass])) {
        $this->_dateTimes[$attribute]->attributes = $formData[$this->dateTimeFormClass];
      }
    }
  }
  public function getDateTimes() {
    return $this->_dateTimes;
  }
  public function getDateTimeForm($attribute) {
    return HArray::val($this->_dateTimes, $attribute);
  }
  public function attach($owner) {
		parent::attach($owner);
		$owner->getValidatorList()->add(
		  CValidator::createValidator('safe', $this->owner, array('dateTimes'))
		);
	}
	public function addDateTimeForm(DateTimeForm $form) {
	  $this->_dateTimes[$form->dateTimeAttribute] = $form;
	}
	public function beforeValidate($event) {
	  parent::beforeValidate($event);
	  $valid = true;
	  foreach ($this->getDateTimes() as $dateTimeForm) {
	    $valid = $dateTimeForm->validate() && $valid;
	    if (!$dateTimeForm->hasErrors()) {
	      $this->owner->{$dateTimeForm->dateTimeAttribute} = $dateTimeForm->getTimestamp();
	    } else {
	      foreach ($dateTimeForm->getErrors() as $attribute => $errors) {
	        $event->sender->addErrors(array($dateTimeForm->dateTimeAttribute => $errors));
	      }
	    }
	  }
	  $event->isValid = $valid;
	}
}