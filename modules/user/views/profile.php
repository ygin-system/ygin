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
        <?php echo $model->getEncodedName(); ?>
    </div>
<!-- +not-encode-mail -->
    <div class="form-group">
      <?php echo $form->labelEx($model, 'mail', array('class'=>'control-label')); ?>
        <?php echo $form->textField($model, 'mail', array('class' => 'form-control', 'type' => 'email')); ?>
        <?php echo $form->error($model, 'mail'); ?>
    </div>
<!-- -not-encode-mail -->
    <div class="form-group">
        <button type="button" class="btn btn-default btn-sm" onclick="$(this).remove(); $('#passRow').show();">Изменить пароль</button>
      <div id="passRow" style="display:none">
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
    </div>
    <div class="form-group">
      <?php echo $form->labelEx($model, 'full_name', array('class'=>'control-label')); ?>
        <?php echo $form->textField($model, 'full_name', array('class'=>'form-control', 'rows' => '8')); ?>
        <?php echo $form->error($model, 'full_name'); ?>
    </div>
    <?php echo CHtml::submitButton('Сохранить', array('class' => 'btn btn-success')); ?>
  </fieldset>
<?php $this->endWidget(); ?>