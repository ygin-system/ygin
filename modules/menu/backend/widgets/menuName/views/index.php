<?php

/**
 * @var $this MenuNameWidget
 */

$visualElement = $this->createChildWidget('TextFieldWidget', $this->getObjectParameter()->getFieldName());
$visualElement->run(); // name

if ($this->model->isNewRecord) {
  //если пустое чпу, создаём транслитом из имени раздела
  $elName = $visualElement->getElementName();
  $visualElement = $this->createChildWidget('TextFieldWidget', 'alias');
  $elAlias = $visualElement->getElementName();

  $js = 'var admAutoMode = true; var admAliasFocus = false;
  $("input[name=\"'.$elName.'\"]").keyup(function() {
      if (admAutoMode)
        $("input[name=\"'.$elAlias.'\"]").val( yginTranslit( $("input[name=\"'.$elName.'\"]").val() ) );
    }
  );
  $("input[name=\"'.$elAlias.'\"]").focus(function(){admAliasFocus = true;}).blur(function(){admAliasFocus = false;}).change(function(){if(admAliasFocus) admAutoMode = false;});';

  Yii::app()->clientScript->registerScript('element.menu.name', $js, CClientScript::POS_READY);
}
