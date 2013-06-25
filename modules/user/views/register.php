<?php
/* @var UserController $this */
$cs = Yii::app()->clientScript;
$this->registerJsFile('user.js');
$cs->registerScript(
  "registerForm",
  "User.showPassBind('showPass','register-form','".CHtml::activeName($model, "user_password")."');",
  CClientScript::POS_READY
);

$form = $this->beginWidget('CActiveForm', array(
  'id' => 'register-form',
  'enableAjaxValidation' => true,
  'enableClientValidation' => true,
  'focus' => array($model, 'name'),
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
    <div class="control-group">
      <?php echo $form->labelEx($model, 'name', array('class'=>'control-label')); ?>
      <div class="controls">
        <?php echo $form->textField($model, 'name', array('class' => 'input-xlarge')); ?>
        <?php echo $form->error($model, 'name'); ?>
      </div>
    </div>
<!-- +not-encode-mail -->
    <div class="control-group">
      <?php echo $form->labelEx($model, 'mail', array('class'=>'control-label')); ?>
      <div class="controls">
        <?php echo $form->textField($model, 'mail', array('class' => 'input-xlarge', 'type' => 'email')); ?>
        <?php echo $form->error($model, 'mail'); ?>
      </div>
    </div>
<!-- -not-encode-mail -->
    <div class="control-group">
      <?php echo $form->labelEx($model, 'user_password', array('class'=>'control-label')); ?>
      <div class="controls">
        <?php echo $form->passwordField($model, 'user_password', array('class' => 'input-xlarge')); ?>
        <?php echo $form->error($model, 'user_password'); ?>
        <label for="showPass" class="checkbox">
          <input type="checkbox" id="showPass">
          Показать пароль
        </label>
      </div>
    </div>
    <div class="control-group">
      <?php echo $form->labelEx($model, 'full_name', array('class'=>'control-label')); ?>
      <div class="controls">
        <?php echo $form->textField($model, 'full_name', array('class'=>'input-xlarge', 'rows' => '8')); ?>
        <?php echo $form->error($model, 'full_name'); ?>
      </div>
    </div>
    <div class="control-group">
      <?php echo $form->labelEx($model, 'verifyCode', array('class'=>'control-label')); ?>
      <div class="controls">
        <?php echo $form->textField($model, 'verifyCode', array('class'=>'input-mini', 'title' => 'Укажите код с картинки', 'autocomplete' => 'off')); ?>
        <?php $this->widget('CCaptcha', array('clickableImage' => true, 'captchaAction' => $this->createUrl('captcha'))); ?>
        <?php echo $form->error($model, 'verifyCode', array(), true, false);?>
      </div>
    </div>
    <div class="form-actions">
    <?php echo CHtml::submitButton('Зарегистрироваться', array('class' => 'btn btn-success')); ?>
    </div>
  </fieldset>
<?php $this->endWidget(); ?>