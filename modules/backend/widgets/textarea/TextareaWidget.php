<?php

class TextareaWidget extends VisualElementWidget {

  public $readOnlyView = 'backend.widgets.textarea.views.readOnly';

  public function init() {
    parent::init();
    $this->model->addValidator(CValidator::createValidator('safe', $this->model, $this->attributeName, array('on'=>'backendInsert, backendUpdate')));
  }

}
