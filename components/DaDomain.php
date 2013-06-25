<?php
class DaDomain extends CApplicationComponent {
  public $mainDomainId = 1;
  
  private $_model = null;
  
  /**
   * Получение модели домена
   * @return Domain
   * @throws CException
   */
  public function getModel() {
    if ($this->_model === null) {
      $this->_model = Domain::model()->findByPk($this->mainDomainId);
    }
    
    if ($this->_model === null) {
      throw new CException('Домен с id = '.$this->mainDomainId.' не найден.');
    }
    
    return $this->_model;
  }
}