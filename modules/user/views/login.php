<?php
if (Yii::app()->user->hasFlash('registerSuccess')) {
  $this->widget('AlertWidget', array(
    'title' => 'Успешная регистрация',
    'message' => Yii::app()->user->getFlash('registerSuccess'),
  ));
}
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
  'id' => 'login-form',
  'enableAjaxValidation' => true,
  'enableClientValidation' => true,
  'focus' => array($model, 'username'),
  'htmlOptions' => array(
    'class' => 'form-horizontal',
  ),
  'clientOptions' => array(
    'validateOnSubmit' => true,
    'validateOnChange' => false,
  ),
  'errorMessageCssClass' => 'label label-important',
));
?>
<?php echo $form->errorSummary($model, false); ?>
  <fieldset>
  <!-- +not-encode-mail -->
    <div class="control-group">
      <?php echo $form->labelEx($model, 'username', array('class'=>'control-label')); ?>
      <div class="controls">
        <?php echo $form->textField($model, 'username', array('class' => 'input-xlarge')); ?>
        <?php echo $form->error($model, 'username'); ?>
      </div>
    </div>
  <!-- -not-encode-mail -->
    <div class="control-group">
      <?php echo $form->labelEx($model, 'password', array('class'=>'control-label')); ?>
      <div class="controls">
        <?php echo $form->passwordField($model, 'password', array('class' => 'input-xlarge')); ?>
        <?php echo $form->error($model, 'password'); ?>
      </div>
    </div>
    <div class="control-group">
      <div class="controls">
        <label class="checkbox">
        <?php echo $form->checkBox($model, 'rememberMe');?>
        <?php echo $model->getAttributeLabel('rememberMe'); ?>
        </label>
        <?php echo $form->error($model, 'rememberMe'); ?>
      </div>
    </div>
    <div class="form-actions">
    <?php echo CHtml::submitButton('Войти', array('class' => 'btn btn-success')); ?>
    </div>
  </fieldset>
<?php $this->endWidget(); ?>
