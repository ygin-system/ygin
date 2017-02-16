<?php
class NotifierComponentEvent extends CEvent {
  private $_notifierEvent = null;
  private $_notifierEventProcess = null;
  private $_mailMessage = null;
  private $_isValid = true;
  
  
  public function __construct($sender, NotifierEvent $notifierEvent,
                              NotifierEventProcess $notifierEventProcess,
                              YiiMailMessage $mailMessage, $params = array()) {
    
    $this->_notifierEvent = $notifierEvent;
    $this->_notifierEventProcess = $notifierEventProcess;
    $this->_mailMessage = $mailMessage;
  }
  
  /**
   * Уведомление
   * @return NotifierEvent
   */
  public function getNotifierEvent() {
    return $this->_notifierEvent;
  }
  /**
   * Обрабатываемый адресати из пулас сообщений
   * @return NotifierEventProcess
   */
  public function getNotifierEventProcess() {
    return $this->_notifierEventProcess;
  }
  /**
   * Сообщение, которе будет отправлено на почту
   * @return YiiMailMessage
   */
  public function getMailMessage() {
    return $this->_mailMessage;
  }
  
  public function setIsValid($valid) {
    $this->_isValid = $valid;
  }
  /**
   * Определяет, нужно ли отправлять сообщение
   */
  public function getIsValid() {
    return $this->_isValid;
  }
}