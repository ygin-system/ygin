<?php

/**
 * @var $form CActiveForm
 */

echo $form->textField($model, $attributeName, array('class' => 'field-edit form-control'));
echo $form->error($model, $attributeName);