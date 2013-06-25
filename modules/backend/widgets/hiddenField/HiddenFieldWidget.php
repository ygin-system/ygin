<?php

class HiddenFieldWidget extends VisualElementWidget {

  public $layout = false;
  public $readOnlyView = 'backend.widgets.hiddenField.views.readOnly';

  public function init() {
    parent::init();
    $this->model->addValidator(CValidator::createValidator('length', $this->model, $this->attributeName, array('on'=>'backendInsert, backendUpdate', 'max'=>255)));
  }

}
