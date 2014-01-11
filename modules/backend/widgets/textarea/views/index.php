<?php

/**
 * @var $form CActiveForm
 */

echo $form->textArea($model, $attributeName, array('class' => 'iTextarea form-control', 'rows' => 5, 'style' => 'white-space:normal'));
echo $form->error($model, $attributeName);