<?php
class AlertWidget extends DaWidget {
  
  const ERROR = 0;
  const WARNING = 1;
  const SUCCESS = 2;
  
  public $message = null;
  public $title = null;
  public $btTitle = 'OK';
  public $type = 'success';
  
  private static $_cnt = 0;
  
  public function init() {
    if ($this->title === null) {
      $this->title = Yii::app()->name;
    }
    $this->registerJsFile('daAlert-min.js');
  }
  
  public function run() {
    $msgType = array(
      'success' => 'alert-success',
      'error' => 'alert-danger',
      'warning' => 'alert-info',
    );
    $type = HArray::val($msgType, $this->type, 'alert-info');

    $script = "daAlert(".CJavaScript::encode($this->title).", ".CJavaScript::encode($this->message).", '".$this->btTitle."', '".$type."');";
    $cs = Yii::app()->clientScript;
    $cs->registerScript(__CLASS__.(self::$_cnt++), $script, CClientScript::POS_READY);
  }

}