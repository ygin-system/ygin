<?php
class AlertWidget extends CWidget {
  
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
    $this->registerScripts();
  }
  
  public function run() {
    $msgType = array(
      'success' => 'alert-success',
      'error' => 'alert-error',
      'warning' => 'alert-info',
    );
    $type = HArray::val($msgType, $this->type, 'alert-info');

    $script = "daAlert(".CJavaScript::encode($this->title).", ".CJavaScript::encode($this->message).", '".$this->btTitle."', '".$type."');";
    $cs = Yii::app()->clientScript;
    $cs->registerScript(__CLASS__.(self::$_cnt++), $script, CClientScript::POS_READY);
  }
  
  protected function getAssetsDir() {
    return dirname(__FILE__).DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR;
  }
  
  public function registerScripts() {
    $cs = Yii::app()->clientScript;
    $file = CHtml::asset($this->getAssetsDir().'daAlert-min.js');
    $cs->registerScriptFile($file);
  }
  
}