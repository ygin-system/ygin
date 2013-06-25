<?php

class TextFieldWidget extends VisualElementWidget {

  public $readOnlyView = 'backend.widgets.textField.views.readOnly';

  public function init() {
    parent::init();
    if ($this->isInt()) {
      $this->model->addValidator(CValidator::createValidator('numerical', $this->model, $this->attributeName, array('on'=>'backendInsert, backendUpdate')));
    } else {
      $this->model->addValidator(CValidator::createValidator('length', $this->model, $this->attributeName, array('on'=>'backendInsert, backendUpdate', 'max'=>255)));
    }
  }

  private function isInt() {
    return ($this->getObjectParameter()->getType() == DataType::INT);
  }
  public function onPostForm(PostFormEvent $event) {
    $value = $this->getFormValue();
    if (trim($value) === '') $value = null;
    if ($this->isInt()) {
      $value = floatval(str_replace(",", ".", $value));
    }
    $this->model->{$this->attributeName} = $value;
  }

}
