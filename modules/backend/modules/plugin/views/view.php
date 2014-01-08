<?php
  $this->caption = 'Настройка плагина "'.$plugin->getName().'"';
  
  $desc = ($plugin->getDescription() == null ? $plugin->getShortDescription() : $plugin->getDescription());
  echo CHtml::tag('div', array('class'=>'well'), $desc);
  
$form = $this->beginWidget('CActiveForm', array(
  'id' => 'pluginForm',
  'enableAjaxValidation' => true,
  'enableClientValidation' => true,
  'htmlOptions' => array(
    'class' => 'form-horizontal b-instance-edit-form',
    //'style' => 'display:'.$hidden.';',
  ),
  'clientOptions' => array(
    'validateOnSubmit' => true,
    'validateOnChange' => false,
  ),
  //'errorMessageCssClass' => 'label label-danger',
  'action' => Yii::app()->createUrl(PluginModule::ROUTE_PLUGIN_VIEW, array('code' => $plugin->code)),
));

?>
    <fieldset>
<?php
  echo CHtml::errorSummary($model);
  foreach ($parameters AS $name => $option) {

    $label = $form->labelEx($model, $name, array('class'=>'control-label'));
    $hint = (isset($option['description']) ? $option['description'] : null);
    $content = '';
    if ($option['type'] == DataType::INT) {
      $content = $form->textField($model, $name);
    } else if ($option['type'] == DataType::BOOLEAN) {
      $content = $form->checkBox($model, $name);
    } else if ($option['type'] == DataType::RADIO) {
      $content = $form->radioButtonList($model, $name, $model->getOptions($name), array('template'=>'<div class="radio">{input} {label}</div>', 'separator'=>'', 'labelOptions'=>array('class'=>'label-radio')));
    } else if ($option['type'] == DataType::TEXTAREA) {
      $content = $form->textArea($model, $name, array('rows'=>11));
    }
    $content .= $form->error($model, $name);
    
    $view = (isset($option['view']) ? $option['view'] : '/_template');
    $this->renderPartial($view, array(
        'label' => $label,
        'hint' => $hint,
        'content' => $content,
    ));
  }
?>
    <div class="form-actions">
      <div class="progress-bar">
        <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-ok icon-white"></i> Сохранить</button>
        <a class="btn btn-danger" href="<?php echo Yii::app()->createUrl(PluginModule::ROUTE_PLUGIN_LIST); ?>"><i class="glyphicon glyphicon-remove icon-white"></i> Отменить</a>
      </div>
    </div>
    </fieldset>
<?php $this->endWidget(); ?>