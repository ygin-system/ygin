<?php
/* @var UserController $this */
$cs = Yii::app()->clientScript;
$this->registerJsFile('user.js');
$cs->registerScript(
  "profileForm",
  "User.showPassBind('showPass','profile-form','".CHtml::activeName($model, "user_password")."');",
  CClientScript::POS_READY
);

if (Yii::app()->user->hasFlash('profileSuccess')) {
  $this->widget('AlertWidget', array(
    'title' => $this->caption,
    'message' => Yii::app()->user->getFlash('profileSuccess'),
  ));
}

if (Yii::app()->user->hasFlash('registerSuccess')) {
  $this->widget('AlertWidget', array(
    'title' => 'Успешная регистрация',
    'message' => Yii::app()->user->getFlash('registerSuccess'),
  ));
}

$form = $this->beginWidget('CActiveForm', array(
  'id' => 'profile-form',
  'enableAjaxValidation' => true,
  'enableClientValidation' => true,
  'focus' => array($model, 'mail'),
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
        <?php echo $model->getEncodedName(); ?>
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
      <div class="controls">
        <button type="button" class="btn btn-small" onclick="$(this).parent().remove(); $('#passRow').show();">Изменить пароль</button>
      </div>
      <div id="passRow" style="display:none">
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
    </div>
    <div class="control-group">
      <?php echo $form->labelEx($model, 'full_name', array('class'=>'control-label')); ?>
      <div class="controls">
        <?php echo $form->textField($model, 'full_name', array('class'=>'input-xlarge', 'rows' => '8')); ?>
        <?php echo $form->error($model, 'full_name'); ?>
      </div>
    </div>
    <div class="form-actions">
    <?php echo CHtml::submitButton('Сохранить', array('class' => 'btn btn-success')); ?>
    </div>
  </fieldset>
<?php $this->endWidget(); ?>