<?php
  $this->layout = 'backend.views.layouts.auth';
  $this->setPageTitle('Панель управления');
  
  if (Yii::app()->user->returnUrl == null) Yii::app()->user->returnUrl = Yii::app()->homeUrl;
  
  // автофокус
  $elementId = null;
  if ($model->username != null) {
    $elementId = '#LoginForm_password';
  } else {
    $elementId = '#LoginForm_username';
  }
  Yii::app()->clientScript->registerScript('auth.init', '
    $(".b-field-notnull")
      .live({
        keyup  : function(){$(this).daNotNullChange();},
        blur   : function(){$(this).daNotNullChange(); },
        click  : function(){$(this).daNotNullChange();},
        change : function(){$(this).daNotNullChange();},
      })
      .daNotNullChange();
  $("'.$elementId.'").focus();
  $(":submit").button({icons:{primary:"ui-icon-key"}});
  ', CClientScript::POS_READY);
  

  $form = $this->beginWidget('CActiveForm', array(
    'id'=>'login-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
    'clientOptions' => array(
      'validateOnSubmit' => false,
      'validateOnChange' => false,
    ),
    'action' => Yii::app()->createUrl(UserModule::ROUTE_ADMIN_LOGIN),
    'errorMessageCssClass' => 'label label-danger',
    'htmlOptions' => array(
      'class' => 'b-login-form',
      'role'  => 'form',
    ),
  ));
?>

<fieldset>
  <div class="form-group">
    <label for="LoginForm_username">Логин:</label>
    <?php echo $form->textField($model, 'username', array('class'=>'form-control nullField', 'size'=>15, 'autofocus'=>'autofocus')); ?>
  </div>
  <div class="form-group">
    <label for="LoginForm_password">Пароль:</label>
    <?php echo $form->passwordField($model, 'password', array('class'=>'form-control nullField', 'size'=>15)); ?>
  </div>
  <div>
    <table><tr>
    <td>
      <button type="submit" class="btn btn-default btn-lg"><i class="glyphicon glyphicon-check"></i> Войти</button>
    </td>
    <td class="checkbox">
      <label>
        <?php echo $form->checkBox($model, 'rememberMe', array('class' => 'remind')); ?> <?php echo $form->label($model, 'rememberMe', array('label' => 'запомнить меня')); ?>
      </label>
    </td>
    </tr>
    </table>
  </div>
</fieldset>

<div class="ygin-copy">&copy; 2014, <a target="_blank" href="http://ygin.ru" class="label label-danger">ygin</a></div>
<?php $this->endWidget(); ?>
<?php
  if ($model->username != null || $model->password != null) {  // TODO: пользователь также может быть заблокирован. Или не иметь в принципе доступа в админку
    echo '<div class="alert alert-danger">
            <i class="glyphicon glyphicon-warning-sign"></i> Вы ввели неверный логин или пароль.
          </div>';
  }
?>