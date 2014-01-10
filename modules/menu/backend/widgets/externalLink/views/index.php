<?php

$visualElement = $this->createChildWidget('TextFieldWidget', 'external_link');
$visualElement->run();

$visualElement = $this->createChildWidget('CheckBoxWidget', 'external_link_type', $this->model, false, array(
  'label' => 'Открыть в новом окне',
));
$visualElement->run();
