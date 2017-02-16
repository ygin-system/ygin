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
    'class' => '',
    'role' => 'form',
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
    <div class="form-group">
      <?php echo $form->labelEx($model, 'username', array('class'=>'control-label')); ?>
        <?php echo $form->textField($model, 'username', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'username'); ?>
    </div>
  <!-- -not-encode-mail -->
    <div class="form-group">
      <?php echo $form->labelEx($model, 'password', array('class'=>'control-label')); ?>
            <?php echo $form->passwordField($model, 'password', array('class' => 'form-control')); ?>
            <?php echo $form->error($model, 'password'); ?>
    </div>
    <div class="checkbox">
        <label>
        <?php echo $form->checkBox($model, 'rememberMe');?>
        <?php echo $model->getAttributeLabel('rememberMe'); ?>
        </label>
        <?php echo $form->error($model, 'rememberMe'); ?>
    </div>
    <?php echo CHtml::submitButton('Войти', array('class' => 'btn btn-success')); ?>
  </fieldset>
<?php $this->endWidget(); ?>
