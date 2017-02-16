<?php
  /**
   * @var Comment model
   * @var CActiveForm $form
   */

  if ($newComment->config['premoderate']) {
    $this->registerJsFile('daAlert-min.js', 'ygin.widgets.alert.assets');
    Yii::app()->clientScript->registerScript("addComAlert", '
      $.fn.commentsList.postComment = function($dialog){
        $(".b-comment-form .submit").button("loading");
        var $form = $(".b-comment-form", $dialog);
        $.post(
          $form.attr("action"),
          $form.serialize()
        ).success(function(data){
          $(".b-comment-form .submit").button("reset");
          data = $.parseJSON(data);
          $dialog.html(data[".b-comment-form"]);
          if(data["code"] == "success") {
            daAlert("Ваш комментарий успешно добавлен.", "Спасибо за оставленный комментарий, он появится на странице после проверки модератором", "Ок", "alert-success");
            $.fn.commentsList.overdrawCommentList($dialog, data);
          }
        });
      };
    ');
  }

  $form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->urlManager->createUrl($this->postCommentAction),
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'htmlOptions' => array(
      'class' => 'b-comment-form form-horizontal',
      'name' => 'commentform',
    ),
    'clientOptions' => array(
      'validateOnSubmit' => true,
      'validateOnChange' => false,
      //'beforeValidate' => 'js:function(form){  }',
    ),
  ));
?>
  <fieldset>
    <legend>Добавить комментарий</legend>
    <?php //echo $form->errorSummary($newComment); ?>
    <?php
      echo $form->hiddenField($newComment, 'id_object');
      echo $form->hiddenField($newComment, 'id_instance');
      echo $form->hiddenField($newComment, 'id_parent', array('class' => 'parent_comment_id'));
    ?>
    <div class="form-group">
      <?php echo $form->labelEx($newComment, 'comment_name', array('class' => 'control-label col-md-2 col-lg-2')); ?>
      <div class="col-md-10 col-lg-8">
        <?php if (Yii::app()->user->isGuest === true): ?>
          <?php
          echo $form->textField($newComment, 'comment_name', array(
            'size' => 40,
            'class' => 'form-control',
            'title' => 'Ваше имя',
            'autocomplete' => 'off',
          ));
          ?>
          <?php echo $form->error($newComment, 'comment_name'); ?>
        <?php else: ?>
          <?php $curUser = Yii::app()->user->getModel(); ?>
          <?php echo '<div class="commentator_name">' . $curUser->full_name . '</div>'; ?>
          <?php
          /*<?php if (($preview = $curUser->getImagePreview('_small')) !== null && in_array($curUser->id_group, array(BlogUser::GROUP_ID, BlogUser::ADMINBLOG_GROUP))):?>
          <img alt="<?=$curUser->full_name;?>" src="<?=$preview->getUrlPath();?>">
          <?php endif;?>
          <?php echo $curUser->full_name;?>
          */
          ?>
        <?php endif; ?>
      </div>
    </div>

    <div class="form-group">
      <?php echo $form->labelEx($newComment, 'comment_theme', array('class' => 'control-label col-md-2 col-lg-2')); ?>
      <div class="col-md-10 col-lg-8">
        <?php
          echo $form->textField($newComment, 'comment_theme', array(
            'size' => 40,
            'class' => 'form-control',
            'title' => 'Тема',
            'autocomplete' => 'off',
          ));
        ?>
        <?php echo $form->error($newComment, 'comment_theme'); ?>
      </div>
    </div>

    <div class="form-group">
      <?php echo $form->labelEx($newComment, 'comment_text', array('class' => 'control-label col-md-2 col-lg-2')); ?>
      <div class="col-md-10 col-lg-8">
        <?php
          echo $form->textArea($newComment, 'comment_text', array(
            'rows' => 8,
            'class' => 'form-control',
            'title' => 'Комментарий',
            'placeholder' => 'Комментарий',
            'autocomplete' => 'off',
          ));
        ?>
        <?php echo $form->error($newComment, 'comment_text'); ?>
      </div>
    </div>

    <?php if ($this->useCaptcha === true && extension_loaded('gd')): ?>
      <div class="form-group">
        <?php echo $form->labelEx($newComment, 'verifyCode', array('class' => 'control-label col-md-2')); ?>
        <div class="col-md-2">
          <?php echo $form->textField($newComment, 'verifyCode', array(
            'title' => 'Укажите код с картинки',
            'autocomplete' => 'off',
            'class' => 'form-control col-md-10'
          )); ?>
          <?php echo $form->error($newComment, 'verifyCode', array(), true, false); ?>
        </div>
        <div class="captcha col-md-8">
          <?php $this->widget('CCaptcha', array(
            'clickableImage' => true,
            'captchaAction' => CommentsModule::CAPTCHA_ACTION_ROUTE,
          )); ?>
        </div>
      </div>
    <?php endif; ?>
    <div class="form-group">
      <div class="col-md-10 col-md-offset-2">
        <?php echo CHtml::htmlButton('Отправить', array(
          'name' => 'btn',
          'type' => 'submit',
          'class' => 'btn btn-default',
          'data-loading-text' => 'Отправляется...',
        )); ?>
      </div>
    </div>
  </fieldset>
<?php $this->endWidget(); ?>