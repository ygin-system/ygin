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
    'errorMessageCssClass' => 'label label-important',
  	'htmlOptions' => array(
  	  'class' => 'authorization form-vertical'
  	),
  ));
  $idPrefix = 'login_widget_';
  echo $form->textField($model, 'username', array('class'=>'span3', 'placeholder'=>'Логин', 'id' => $idPrefix.CHtml::activeId($model, 'username')));
  echo $form->error($model, 'username', array('inputID' => $idPrefix.CHtml::activeId($model, 'username')));
  echo $form->passwordField($model, 'password', array('class'=>'span3', 'placeholder'=>'Пароль', 'id' => $idPrefix.CHtml::activeId($model, 'password')));
  echo $form->error($model, 'password', array('inputID' => $idPrefix.CHtml::activeId($model, 'password')));
 	echo CHtml::submitButton('Войти', array('class'=>'btn'));
		
  $this->endWidget();?>

  <?php endif; ?>
</div>