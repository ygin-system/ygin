<?php
/* @var UserController $this */
/*
$cs = Yii::app()->clientScript;
$this->registerJsFile('user.js');
$cs->registerScript(
  "profileForm",
  "User.showPassBind('showPass','profile-form','".CHtml::activeName($model, "user_password")."');",
  CClientScript::POS_READY
);
*/

if (Yii::app()->user->hasFlash('recoverSuccess')) {
  $this->widget('AlertWidget', array(
    'title' => $this->caption,
    'message' => Yii::app()->user->getFlash('recoverSuccess'),
  ));
}
?>
<p><span class="label label-warning">Внимание!</span>Восстановление пароля возможно только, если вы указали e-mail в своем профиле.</p>
<?php
$form = $this->beginWidget('CActiveForm', array(
  'id' => 'recover-form',
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
<!-- +not-encode-mail -->
    <div class="control-group">
      <?php echo $form->labelEx($model, 'login', array('class'=>'control-label')); ?>
      <div class="controls">
        <?php echo $form->textField($model, 'login', array('class' => 'input-xlarge')); ?>
        <?php echo $form->error($model, 'login'); ?>
      </div>
    </div>
<!-- -not-encode-mail -->
    <div class="form-actions">
    <?php echo CHtml::submitButton('Восстановить', array('class' => 'btn btn-success')); ?>
    </div>
  </fieldset>
<?php $this->endWidget(); ?>