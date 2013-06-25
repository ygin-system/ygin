<?php

class PluginParameters extends CFormModel {

  private $_params = array();

  public function setParameters(array $params) {
    $this->_params = $params;
  }
  public function getParamsValue() {
    $result = array();
    foreach($this->_params AS $name => $option) {
      $result[$name] = $this->$name;
    }
    return $result;
  }
  
  public function __get($name) {
    if (isset($this->_params[$name])) {
      if (isset($this->_params[$name]['value'])) {
        return $this->_params[$name]['value'];
      }
      return (isset($this->_params[$name]['default']) ? $this->_params[$name]['default'] : null);
    }
    return parent::__get($name);
  }
  public function __isset($name) {
    if (isset($this->_params[$name])) {
      return true;
    }
    return parent::__isset($name);
  }
  public function __set($name, $value) {
    if (isset($this->_params[$name])) {
      if ($this->_params[$name]['type'] == DataType::BOOLEAN && is_string($value)) {
        $value = ($value === '1');
      }
      $this->_params[$name]['value'] = $value;
      return;
    }
    parent::__set($name, $value);
  }

  public function getOptions($name) {
    $result = array();
    if (isset($this->_params[$name]) && isset($this->_params[$name]['options'])) {
      $result = $this->_params[$name]['options'];
    }
    return $result;
  }
  


  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    $rules = array();

    $integerOnly = array();
    $safe = array();
    $required = array();
    foreach ($this->_params AS $name => $option) {
      $set = false;
      if (in_array($option['type'], array(DataType::INT))) {
        $integerOnly[] = $name;
        $set = true;
      }
      if (isset($option['required']) && $option['required'] === true) {
        $required[] = $name;
        $set = true;
      }
      if (!$set) {
        $safe[] = $name;
      }
    }
    if (count($integerOnly) > 0)
      $rules[] = array(implode(', ', $integerOnly), 'numerical', 'integerOnly' => true);
    if (count($required) > 0)
      $rules[] = array(implode(', ', $required), 'required');
    if (count($safe) > 0)
      $rules[] = array(implode(', ', $safe), 'safe');

    return $rules;
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    $labels = array();
    foreach($this->_params AS $name => $option) {
      $labels[$name] = $option['label'];
    }
    return $labels;
  }

}