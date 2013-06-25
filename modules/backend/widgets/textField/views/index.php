<?php

/**
 * @var $form CActiveForm
 */

echo $form->textField($model, $attributeName, array('class' => 'field-edit span6'));
echo $form->error($model, $attributeName);