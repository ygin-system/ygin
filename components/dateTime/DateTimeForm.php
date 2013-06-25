<?php
class DateTimeForm extends CFormModel {
  public $isTimeAvailable = true;
  public $dateFormat = 'dd.MM.yyyy';
  public $timeFormat = 'HH:mm:ss';
  private $_date;
  private $_time;
  public $tsDate;
  public $tsTime;
  public $dateTimeAttribute;
  private $_owner;
  public $required;
  public function setOwner($model) {
    $this->_owner = $model;
  }
  public function getOwner() {
    return $this->_owner;
  }
  public function rules() {
    $rules = array(
      array('date', 'date', 'format' => 'dd.MM.yyyy', 'timestampAttribute' => 'tsDate'),
    );
    if ($this->required) {
      $rules[] = array('date', 'required');
    }
    if ($this->isTimeAvailable) {
      $rules[] = array('time', 'date', 'format' => 'HH:mm:ss', 'timestampAttribute' => 'tsTime');
      if ($this->required) {
        $rules[] = array('time', 'required');
      }
    }
    return $rules;
  }
  public function attributeLabels() {
    return array(
      'date' => 'Дата для поля '.$this->_owner->getAttributeLabel($this->dateTimeAttribute),
      'time' => 'Время для поля '.$this->_owner->getAttributeLabel($this->dateTimeAttribute),
    );
  }
  public function getDate() {
    if ($this->_date === null) {
      if (!empty($this->_owner{$this->dateTimeAttribute})) {
        $this->_date = Yii::app()->dateFormatter->format($this->dateFormat, $this->_owner{$this->dateTimeAttribute});
      } else {
        if ($this->required) {
          $this->_date = Yii::app()->dateFormatter->format($this->dateFormat, time());
        }
      }
    }
    return $this->_date;
  }
  public function getTime() {
    if ($this->_time === null) {
      if (!empty($this->_owner{$this->dateTimeAttribute})) {
        $this->_time = Yii::app()->dateFormatter->format($this->timeFormat, $this->_owner{$this->dateTimeAttribute});
      } else {
        if ($this->required) {
          $this->_time = Yii::app()->dateFormatter->format($this->timeFormat, time());
        }
      }
    }
    return $this->_time;
  }
  public function setDate($date) {
    $this->_date = $date;
  }
  public function setTime($time) {
    $this->_time = $time;
  }
  public function getTimestamp() {
    $ts = null;
    if ($this->tsDate !== null) {
      $ts = $this->tsDate;
    }
    if ($this->isTimeAvailable && $this->tsTime !== null) {
      $ts += $this->tsTime - HDate::getTimestampOnBeginning((int)$this->tsTime, HDate::BEGINNING_DAY);
    }
    return $ts;
  }
}