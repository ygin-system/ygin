<?php
  /**
 * @var CreateForm $model
   * @var CActivrForm $form
 */
?>
<?php  $form = $this->beginWidget('CActiveForm', array(
  'id' => 'viewGen-form',
  'enableAjaxValidation' => true,
  'enableClientValidation' => true,
  'focus' => array(
    $model,
    'filename'
  ),
  'htmlOptions' => array(
    'class' => '',
  ),
  'clientOptions' => array(
    'validateOnSubmit' => true,
    'validateOnChange' => false,
  ),
  'errorMessageCssClass' => 'label label-important',
));?>
  <div class="form-group">
    <?php echo $form->labelEx($model,'filename' ); ?>
    <?php echo $form->textField($model,'filename', array('class' => 'form-control', 'value' => 'page_'.date('d_m_Y_H_i_s')));?>
    <?php echo $form->error($model,'filename', array('class' =>'label label-danger')); ?>
  </div>

  <div class="form-group">
    <?php echo $form->labelEx($model,'caption' ); ?>
    <?php echo $form->textField($model,'caption', array('class' => 'form-control'));?>
    <?php echo $form->error($model,'caption', array('class' =>'label label-danger')); ?>
  </div>

  <div class="form-group" style="position: relative;">
    <?php echo $form->labelEx($model,'path'); ?>
    <label for="CreateViewForm_path" style="padding-top: 14px;  position: absolute; font-weight: normal; left: 0; top: 20px;padding-left: 10px;"><?php echo CreateViewForm::VIEWS_PATH; ?></label>
    <?php echo $form->textField($model,'path', array('class' => 'form-control', 'style' => 'padding-left: 156px;'));?>
    <?php echo $form->error($model,'path', array('class' =>'label label-danger')); ?>
  </div>
  <button type="submit" class="btn btn-success">Создать</button>
<?php $this->endWidget();