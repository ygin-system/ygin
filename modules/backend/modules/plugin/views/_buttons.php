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
    echo CHtml::link('<i class="glyphicon glyphicon-cog"></i> Настройки', $link, array('class' => 'btn btn-primary btn-sm')).' ';
  }
  
  $idObjectStr = (Yii::app()->backend->object == null ? 'null' : Yii::app()->backend->object->id_object);
  $idObjectViewStr = (Yii::app()->backend->objectView == null ? 'null' : Yii::app()->backend->objectView->id_object_view);

  $url = Yii::app()->createUrl('backend/ygin/updateMenu');
  
  // генерировать надо все блоки всегда, чтобы правильно работал ajax
  echo CHtml::ajaxLink('<i class="glyphicon glyphicon-off"></i> Отключить', Yii::app()->createUrl('backend/plugin/plugin/turnOff', array('code'=>$code)), array(
      'type' => 'POST',
      'dataType' => 'json',
      'success' => 'function(data){if (data.error !== undefined) {alert(data.error); return;} jQuery("#plugin_buttons_'.$id.'").html(data.html); if (data.updateMenu === true) {$("#menu-side-main").daUpdateMenu({"idObject":'.$idObjectStr.', "idObjectView":'.$idObjectViewStr.', "url":"'.$url.'"});} }',
  ), array(
      'class' => 'btn btn-default btn-sm',
      'id' => 'pluginTurnOff-'.$id,
      'style' => 'display:'.($status != Plugin::STATUS_DISABLE ? 'inline-block' : 'none'),
  )).' ';
  echo CHtml::ajaxLink('<i class="glyphicon glyphicon-check"></i> Включить', Yii::app()->createUrl('backend/plugin/plugin/turnOn', array('code'=>$code)), array(
      'type' => 'POST',
      'dataType' => 'json',
      'success' => 'function(data){if (data.error !== undefined) {alert(data.error); return;} jQuery("#plugin_buttons_'.$id.'").html(data.html); if (data.updateMenu === true) {$("#menu-side-main").daUpdateMenu({"idObject":'.$idObjectStr.', "idObjectView":'.$idObjectViewStr.', "url":"'.$url.'"});} }',
  ), array(
      'class' => 'btn btn-success btn-sm',
      'id' => 'pluginTurnOn-'.$id,
      'style' => 'display:'.($status != Plugin::STATUS_DISABLE ? 'none' : 'inline-block'),
  )).' ';
  echo CHtml::ajaxLink('<i class="glyphicon glyphicon-remove"></i> Удалить', Yii::app()->createUrl('backend/plugin/plugin/delete', array('code'=>$code)), array(
      'type' => 'POST',
      'dataType' => 'script',
      //'data' => 'plugin='.$plugin->code,
  ), array(
      'class' => 'btn btn-danger btn-sm',
      'id' => 'pluginDelete-'.$id,
  )).' ';

  