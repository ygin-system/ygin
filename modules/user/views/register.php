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
    'class' => '',
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
    <div class="form-group">
      <?php echo $form->labelEx($model, 'name', array('class'=>'control-label')); ?>
        <?php echo $form->textField($model, 'name', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>
<!-- +not-encode-mail -->
    <div class="form-group">
      <?php echo $form->labelEx($model, 'mail', array('class'=>'control-label')); ?>
        <?php echo $form->textField($model, 'mail', array('class' => 'form-control', 'type' => 'email')); ?>
        <?php echo $form->error($model, 'mail'); ?>
    </div>
<!-- -not-encode-mail -->
    <div class="form-group">
      <?php echo $form->labelEx($model, 'user_password', array('class'=>'control-label')); ?>
        <?php echo $form->passwordField($model, 'user_password', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'user_password'); ?>
        <div class="checkbox">
        <label for="showPass">
          <input type="checkbox" id="showPass">
          Показать пароль
        </label>
        </div>
    </div>
    <div class="form-group">
      <?php echo $form->labelEx($model, 'full_name', array('class'=>'control-label')); ?>
        <?php echo $form->textField($model, 'full_name', array('class'=>'form-control', 'rows' => '8')); ?>
        <?php echo $form->error($model, 'full_name'); ?>
    </div>
    <div class="form-group row">
      <?php echo $form->labelEx($model, 'verifyCode', array('class'=>'control-label col-lg-12')); ?>
        <div class="col-lg-4">
            <?php echo $form->textField($model, 'verifyCode', array('class'=>'form-control', 'title' => 'Укажите код с картинки', 'autocomplete' => 'off')); ?>
        </div>
        <div class="col-lg-3">
            <?php $this->widget('CCaptcha', array('clickableImage' => true, 'captchaAction' => $this->createUrl('captcha'))); ?>
        </div>
        <?php echo $form->error($model, 'verifyCode', array(), true, false);?>
    </div>
    <?php echo CHtml::submitButton('Зарегистрироваться', array('class' => 'btn btn-success')); ?>
  </fieldset>
<?php $this->endWidget(); ?>