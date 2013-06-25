<?php

$visualElement = $this->createChildWidget('TextFieldWidget', 'external_link');
$visualElement->run();

$visualElement = $this->createChildWidget('CheckBoxWidget', 'external_link_type');
echo '<div><label class="checkbox">';
$visualElement->run();
echo 'Открыть в новом окне</label></div>';

