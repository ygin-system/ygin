<?php
class DaConsoleApplication extends CConsoleApplication {

  private $_params = null;
  
  public function getParams() {
    if ($this->_params !== null)
      return $this->_params;
    else {
      $this->_params = new DaApplicationParameters();
      $this->_params->caseSensitive = true;
      return $this->_params;
    }
  }

  public function __construct($config = null) {
    parent::__construct($config);
    register_shutdown_function(array($this, 'onShutdownHandler'));
  }
  
  public function onShutdownHandler() {
    //http://habrahabr.ru/post/136138/
    // 1. error_get_last() returns NULL if error handled via set_error_handler
    // 2. error_get_last() returns error even if error_reporting level less then error
    $e = error_get_last();
  
    $errorsToHandle = E_ERROR | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_COMPILE_WARNING;
  
    if (!is_null($e) && ($e['type'] & $errorsToHandle)) {
      $msg = 'Fatal error: ' . $e['message'];
      // it's better to set errorAction = null to use system view "error.php" instead of run another controller/action (less possibility of additional errors)
      Yii::app()->errorHandler->errorAction = null;
      // handling error
      Yii::app()->handleError($e['type'], $msg, $e['file'], $e['line']);
    }
  }
}