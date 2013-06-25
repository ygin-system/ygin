<?php

/**
 * @var $form CActiveForm
 */

echo $form->textArea($model, $attributeName, array('class' => 'iTextarea span12', 'rows' => 11, 'style' => 'white-space:normal'));
echo $form->error($model, $attributeName);