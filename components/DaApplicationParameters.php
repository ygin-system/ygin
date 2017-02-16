<?php
/**
 * Коллекция системных параметров
 * @author timofeev_ro
 *
 */
class DaApplicationParameters extends CAttributeCollection {
  
  public function __construct($data=null,$readOnly=false) {
    parent::__construct($data, $readOnly);
    $this->load();
  }
  
  public function contains($key) {
    if (!parent::contains($key)) {
      return $this->loadParam($key);
    }
    return true;
  }
  
  public function itemAt($key) {
    if ($this->contains($key)) {
      return parent::itemAt($key);
    }
    return null;
  }
  
  protected function loadParam($key) {
    $param = SystemParameter::model()->findByAttributes(
      array('name' => $key),
      array('select' => 't.name, t.value, t.long_text_value, t.id_system_parameter, t.id_parameter_type')
    );
    if ($param === null) {
      return false;
    }
    $this->add($key, $param->getTypedValue());
    return true;
  }
  /**
   * Этот метод может использоватся для предзагрузки параметров
   * @return boolean
   */
  protected function load() {
    return true;
  }
}