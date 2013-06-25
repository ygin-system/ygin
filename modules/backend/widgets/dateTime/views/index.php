<?php
$dateTimeForm = $model->getDateTimeForm($this->getObjectParameter()->getFieldName());
$dateFormName = get_class($model).'[dateTimes]['.$dateTimeForm->dateTimeAttribute.']['.get_class($dateTimeForm).'][date]';
$timeFormName = get_class($model).'[dateTimes]['.$dateTimeForm->dateTimeAttribute.']['.get_class($dateTimeForm).'][time]';
?>
<span id="<?php echo $this->id.'-date-element'; ?>" class="field-date">
<span class="datepicker">
<?php echo CHtml::textField($dateFormName, $dateTimeForm->date, array(
  'class' => 'input-small',
)); ?>
 <i class="icon-calendar"></i>
</span>&nbsp;
<?php Yii::app()->clientScript->registerScript('admin.date.init', "
  $('.datepicker input').datepicker({
  format    : 'dd.mm.yyyy',
  weekStart : 1,
}).on('changeDate', function(ev){
  $(this).datepicker('hide');
}).on('click', function(){
  $(this).datepicker('show');
});
", CClientScript::POS_READY); ?>


<?php if ($dateTimeForm->isTimeAvailable) : ?>
    <span class="timepicker">
      <?php echo CHtml::textField($timeFormName, $dateTimeForm->time, array(
        'class' => 'input-small',
      )); ?>
      <i class="icon-time"></i>
    </span>&nbsp;
<?php Yii::app()->clientScript->registerScript('admin.time.init', "
  $('.timepicker input').each(function(){
    $(this).timepicker({
      showMeridian : false,
      showSeconds  : true,
      secondStep   : 15,
      minuteStep   : 5,
      defaultTime  : ($(this).val() ? 'value' : false),
    });
  });
", CClientScript::POS_READY); ?>
<?php endif; ?>
<?php if (!$dateTimeForm->required): ?>
<?php Yii::app()->clientScript->registerScript('admin.clear-date-time.init', "
  $('.field-date .clear-date-time').on('click', function() {
    $(this).closest('.field-date').find('input').val('');
  });
", CClientScript::POS_READY); ?>
<span class="clear-date-time" title="очистить">&times;</span>
<?php endif; ?>
  </span>
<?php echo $form->error($dateTimeForm, 'date', array(
  'inputID' => CHtml::getIdByName($dateFormName)
)); ?>
<?php if ($dateTimeForm->isTimeAvailable) : ?>
<?php echo $form->error($dateTimeForm, 'time', array(
  'inputID' => CHtml::getIdByName($timeFormName)
)); ?>
<?php endif; ?>