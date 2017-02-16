<?php

class PhpScriptWidget extends VisualElementWidget {

  public $readOnlyView = false;

  /**
   * @var PhpScriptInstance
   */
  public $phpScript = null;
  public $error = null;

  public function getElementName() {
    $elementName = "ve_";
    $elementName .= $this->objectParameter->getIdParameter();
    return $elementName;
  }

  public function init() {
    parent::init();
    // Элемент работает с одним типом пхп скрипта.
    $idPhpScriptType = HU::get(ObjectUrlRule::PARAM_SYSTEM_MODULE);
    $idPhpScript = $this->model->{$this->attributeName};

    if ($idPhpScript == null && $idPhpScriptType == null) {
      $this->render = false;
      return;
    }
    if ($idPhpScript != null) {
      $this->phpScript = PhpScriptInstance::model()->findByAttributes(array('id_php_script'=>$idPhpScript));
      if ($this->phpScript == null) {
        $this->error = 'Ошибка определения обработчика. Возможно, был удален php-скрипт, привязанный к данному экземпляру.';
        return;
      }
    } else if ($idPhpScriptType != null) { // новый раздел
      $this->phpScript = new PhpScriptInstance();
      $this->phpScript->id_php_script_type = $idPhpScriptType;
    }
  }

  public function onPostForm(PostFormEvent $event) {
    if ($this->render) $this->model->attachEventHandler('onBeforeSave', array($this, 'processModel'));
  }

  public function processModel(CEvent $event) {
    $phpScript = $this->phpScript;
    $phpScriptType = $phpScript->phpScript;
    $paramsConfig = $phpScriptType->getParametersConfig();
    $key = $this->getElementName();
    foreach($paramsConfig AS $name => $config) {
      $val = HU::post($key.'_'.$name);
      $phpScript->setParameterValue($name, $val);
    }
    $phpScript->save();
    $this->model->{$this->attributeName} = $phpScript->id_php_script;
  }

}
