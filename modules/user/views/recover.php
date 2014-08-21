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
<!-- +not-encode-mail -->
    <div class="form-group">
      <?php echo $form->labelEx($model, 'login', array('class'=>'control-label')); ?>
        <?php echo $form->textField($model, 'login', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'login'); ?>
    </div>
<!-- -not-encode-mail -->
    <?php echo CHtml::submitButton('Восстановить', array('class' => 'btn btn-success')); ?>
  </fieldset>
<?php $this->endWidget(); ?>