 <div class="mUser">
   <?php if (!Yii::app()->user->isGuest): ?>
   <div  class="profile">
        <div>
          <span class="name"><?php echo Yii::app()->user->getEscapedName(); ?></span>
          <?php echo CHtml::htmlButton('Выйти', array(
            'onclick' => 'window.location.href = \''.Yii::app()->createUrl(UserModule::ROUTE_LOGOUT).'\'',
          ));?>
        </div>
  </div>
  <?php else: ?>
  
<?php

  $form = $this->beginWidget('CActiveForm', array(
  	'id'=>'login-widget-form',
    'enableAjaxValidation' => false,
  	'enableClientValidation' => true,
  	'clientOptions' => array(
      'validateOnSubmit' => true,
      'validateOnChange' => false,
    ),
  	'action' => Yii::app()->createUrl(UserModule::ROUTE_LOGIN),
    'errorMessageCssClass' => 'label label-danger',
  	'htmlOptions' => array(
  	  'class' => 'authorization'
  	),
  ));
  $idPrefix = 'login_widget_'; ?>
 <div class="form-group">
    <?php echo $form->textField($model, 'username', array('class'=>'form-control', 'placeholder'=>'Логин', 'id' => $idPrefix.CHtml::activeId($model, 'username'))); ?>
    <?php echo $form->error($model, 'username', array('inputID' => $idPrefix.CHtml::activeId($model, 'username'))); ?>
 </div>
 <div class="form-group">
     <?php echo $form->passwordField($model, 'password', array('class'=>'form-control', 'placeholder'=>'Пароль', 'id' => $idPrefix.CHtml::activeId($model, 'password')));?>
    <?php echo $form->error($model, 'password', array('inputID' => $idPrefix.CHtml::activeId($model, 'password')));?>
 </div>
 <?php echo CHtml::submitButton('Войти', array('class'=>'btn btn-default'));?>
		
 <?php $this->endWidget();?>

  <?php endif; ?>
</div>