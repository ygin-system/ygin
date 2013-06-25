<?php

Yii::import('backend.widgets.dropDownList.DropDownObjectWidget', true);

class SelectObjectParameterWidget extends DropDownObjectWidget {

  public $parameterOfObject = null;
  public $parameterOfObjectParameter = null;

  public function init() {
    parent::init();

    $object = $this->model->getObjectInstance();
    $params = $object->parameters;
    foreach($params AS $p) {
      /**
       * @var $p ObjectParameter
       */
      if ($p->getType() == DataType::OBJECT && $p->getAdditionalParameter() == ObjectParameter::ID_OBJECT) {
        $this->parameterOfObjectParameter = $p;
      } else if ($p->getType() == DataType::OBJECT && $p->getAdditionalParameter() == DaObject::ID_OBJECT) {
        $this->parameterOfObject = $p;
      }
    }
  }

}
