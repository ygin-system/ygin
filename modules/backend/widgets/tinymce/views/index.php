<?php

/**
 * @var $form CActiveForm
 * @var $this TinymceWidget
 * @var $tiny ETinyMceYgin
 */

$contentCss = '';
$theme = Yii::app()->getFrontendTheme();
if ($theme != null && file_exists($theme->basePath.'/css/content.css')) {
  $contentCss = $theme->baseUrl.'/css/content.css';
}

$tiny = $this->widget('ygin.ext.tinymce.ETinyMceYgin', CMap::mergeArray(array(
  'model' => $model,
  'attribute' => $attributeName,
  'addPlugin' => array('ygin_clean'),
  'addAdvancedStyles' => array(
    'Таблица в тексте без границ' => 'cTable',
    'Таблица в тексте с границами' => 'cTableB',
  ),
  'addButton' => array(
    array('row'=>3, 'button'=>'ygin_clean', 'before'=>'code'),
  ),
  'addOption' => array(
    'skin' => 'bootstrap',
    'ygin_advlink_show_block_menu' => true,
    'ygin_advlink_show_block_files' => true,
    'setup' => 'js:function(ed) {ed.onPostProcess.add(function(ed, o) {o.content = cleanCode(o.content, true, false, true, true, true, true, true, true, true);});}',
  ),
  'contentCss' => $contentCss,
), $this->options));

$assetsDir = $tiny->assetsPath;
Yii::app()->clientScript->registerScriptFile($assetsDir.'/jquery/functions.js');

echo $form->error($model, $attributeName);