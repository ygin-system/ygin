<?php
//'code'=>$code, 'id'=>$plugin->id_plugin
  $link = $plugin->getUrl();
  $status = $plugin->status;
  $code = $plugin->code;
  $id = $plugin->id_plugin;
  if ($status == Plugin::STATUS_NEW) $status = Plugin::STATUS_DISABLE;
  // если плагин включен и есть настройки
  $showSettingButton = ($status != Plugin::STATUS_DISABLE && count($plugin->getSettingsOfParameters()) > 0);
  
  if ($showSettingButton) {
    echo CHtml::link('<i class="icon-cog icon-white"></i> Настройки', $link, array('class' => 'btn btn-primary')).' ';
  }
  
  $idObjectStr = (Yii::app()->backend->object == null ? 'null' : Yii::app()->backend->object->id_object);
  $idObjectViewStr = (Yii::app()->backend->objectView == null ? 'null' : Yii::app()->backend->objectView->id_object_view);

  $url = Yii::app()->createUrl('backend/ygin/updateMenu');
  
  // генерировать надо все блоки всегда, чтобы правильно работал ajax
  echo CHtml::ajaxLink('<i class="icon-off icon-white"></i> Отключить', Yii::app()->createUrl('backend/plugin/plugin/turnOff', array('code'=>$code)), array(
      'type' => 'POST',
      'dataType' => 'json',
      'success' => 'function(data){if (data.error !== undefined) {alert(data.error); return;} jQuery("#plugin_buttons_'.$id.'").html(data.html); if (data.updateMenu === true) {$("#menu-side-main").daUpdateMenu({"idObject":'.$idObjectStr.', "idObjectView":'.$idObjectViewStr.', "url":"'.$url.'"});} }',
  ), array(
      'class' => 'btn btn-inverse',
      'id' => 'pluginTurnOff-'.$id,
      'style' => 'display:'.($status != Plugin::STATUS_DISABLE ? 'inline-block' : 'none'),
  )).' ';
  echo CHtml::ajaxLink('<i class="icon-check icon-white"></i> Включить', Yii::app()->createUrl('backend/plugin/plugin/turnOn', array('code'=>$code)), array(
      'type' => 'POST',
      'dataType' => 'json',
      'success' => 'function(data){if (data.error !== undefined) {alert(data.error); return;} jQuery("#plugin_buttons_'.$id.'").html(data.html); if (data.updateMenu === true) {$("#menu-side-main").daUpdateMenu({"idObject":'.$idObjectStr.', "idObjectView":'.$idObjectViewStr.', "url":"'.$url.'"});} }',
  ), array(
      'class' => 'btn btn-success',
      'id' => 'pluginTurnOn-'.$id,
      'style' => 'display:'.($status != Plugin::STATUS_DISABLE ? 'none' : 'inline-block'),
  )).' ';
  echo CHtml::ajaxLink('<i class="icon-remove icon-white"></i> Удалить', Yii::app()->createUrl('backend/plugin/plugin/delete', array('code'=>$code)), array(
      'type' => 'POST',
      'dataType' => 'script',
      //'data' => 'plugin='.$plugin->code,
  ), array(
      'class' => 'btn btn-danger',
      'id' => 'pluginDelete-'.$id,
  )).' ';

  