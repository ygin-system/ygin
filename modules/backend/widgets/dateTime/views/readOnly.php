<?php
$timestamp = $model->$attributeName;

if ($this->objectParameter->isRequired() || $timestamp != null) {
  $format = "dd.MM.yyyy";
  if ($this->getIsTimeAvailable()) {
    $format = 'dd.MM.yyyy HH:mm:ss';
  }
  echo "<b>".Yii::app()->dateFormatter->format($format, $timestamp)."</b>";
}
