<?php

class VisualElementBaseWidget extends DaWidget {

  private $_readOnly = false;

  public $render = true;

  public $indexView = 'index';
  public $readOnlyView = 'readOnly';

  public $layout = false;

  /**
   * @var CActiveForm $form
   */
  public $form;
  /**
   * @var DaActiveRecord $model
   */
  public $model;
  public $attributeName;

  /**
   * @param $name
   * @param $attribute
   * @param null $model
   * @param bool $layout
   * @return VisualElementBaseWidget
   */
  public function createChildWidget($name, $attribute, $model=null, $layout=false) {
    if ($model == null) $model = $this->model;
    return $this->controller->createWidget($name, array(
      'form' => $this->form,
      'model' => $this->model,
      'attributeName' => $attribute,
      'layout' => $layout,
    ));
  }

  public function getFormValue() {
    return HU::postModelAttr($this->model, $this->attributeName);
  }

  public final function setReadOnly($readOnly) {
    $this->_readOnly = $readOnly;
  }
  public final function isReadOnly() {
    return $this->_readOnly;
  }
  public function isAdditional() {
    return false;
  }
  public function isAttributeRequired() {
    return ($this->attributeName != null && $this->model->isAttributeRequired($this->attributeName));
  }
  public function getElementName() {
    // Имя элемента
    $elementName = "ve_";
    //if ($this->objectParam->isProperty()) $elementName .= "r";
    $elementName .= md5(get_class($this->model).'_'.$this->attributeName);
    return substr($elementName, 0, 20);
  }

  public function getCaption() {
    return $this->model->getAttributeLabel($this->attributeName);
  }

  public function beforeRender() {
  }

  public function run() {
    $this->beforeRender();

    if (!$this->render) return;

    if ($this->layout !== false) {
      ob_start();
      ob_implicit_flush(false);
    }

    if ($this->_readOnly) {
      if ($this->readOnlyView !== false) {
        $this->render($this->readOnlyView, array(
          'form' => $this->form,
          'model' => $this->model,
          'attributeName' => $this->attributeName,
        ));
      }
    } else {
      $this->render($this->indexView, array(
        'form' => $this->form,
        'model' => $this->model,
        'attributeName' => $this->attributeName,
      ));
    }

    // быстрая черновая версия TODO
    if ($this->layout != false) {
      $content = ob_get_clean();
      require(Yii::getPathOfAlias($this->layout).'.php');
    }
  }

  public function __construct($owner=null) {
    parent::__construct($owner);

    $events = array(
      ViewController::EVENT_ON_POST_FORM => 'onPostForm',
    );
    foreach($events AS $event => $handlerMethod) {
      $owner->attachEventHandler($event, array($this, $handlerMethod));
    }
  }

  public function onPostForm(PostFormEvent $event) {

  }
}
