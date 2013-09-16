<?php

/**
 * @var $this AutoIdKeyWidget
 */

$visualElement = $this->createChildWidget('TextFieldWidget', $this->getObjectParameter()->getFieldName());
$visualElement->run(); // name
