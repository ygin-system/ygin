<?php 
/**
 * @var Comment model
 */

?>

<div class="form">
<?php 
$form=$this->beginWidget('CActiveForm', array(
  'action' => Yii::app()->urlManager->createUrl($this->postCommentAction),
  'htmlOptions' => array(
    'class' => 'mCommentFormBody cSendForm ui-widget-content ui-corner-bottom mobileForm',
    'name' => 'commentform',
    )
)); 
?>
  <div class="writecomment" style="font-weight: bold; margin:10px">
    <div>Добавить комментарий</div>
  </div>
  <?php //echo $form->errorSummary($newComment); ?>
  <?php 
    echo $form->hiddenField($newComment, 'id_object'); 
    echo $form->hiddenField($newComment, 'id_instance'); 
    echo $form->hiddenField($newComment, 'id_parent', array('class'=>'parent_comment_id'));
  ?>
  <table cellspacing="0" cellpadding="0" class="formTable">
    <tr>
      <td style="width:90px;"><?php echo $form->labelEx($newComment, 'comment_name'); ?>:</td>
      <td style="padding-top:7px;">
       <?php if(Yii::app()->user->isGuest === true):?>
       <?php 
         echo $form->textField($newComment,'comment_name', array(
           'size' => 40,
           'class' => 'text void',
           'title' => 'Ваше имя',
           'alt' => 'Имя',
           'placeholder' => 'Меня зовут',
           'autocomplete' => 'off',
         )); 
       ?>
       <?php echo $form->error($newComment,'comment_name'); ?>
       <?php else:?>
       <?php $curUser = Yii::app()->user->getModel();?>
        <?php echo $curUser->full_name;?>
       <?php
       /*<?php if (($preview = $curUser->getImagePreview('_small')) !== null && in_array($curUser->id_group, array(BlogUser::GROUP_ID, BlogUser::ADMINBLOG_GROUP))):?>
       <img alt="<?=$curUser->full_name;?>" src="<?=$preview->getUrlPath();?>">
       <?php endif;?>
       <?php echo $curUser->full_name;?>
       */?>
       <?php endif; ?>
      </td>
    </tr>

    <tr>
      <td><?php echo $form->labelEx($newComment, 'comment_theme'); ?>:</td>
      <td>
        <?php 
          echo $form->textField($newComment, 'comment_theme', array(
            'size' => 40,            
            'class' => 'text void',
            'title' => 'Тема',
            'alt' => 'Тема', 
            'style' => 'width:96%;', 
            'placeholder' => 'Тема',
            'autocomplete' => 'off',
         )); 
        ?>
        <?php echo $form->error($newComment, 'comment_theme'); ?>
      </td>
    </tr>
  
    <tr>
      <td><?php echo $form->labelEx($newComment, 'comment_text'); ?>:</td>
      <td>
        <?php 
          echo $form->textArea($newComment, 'comment_text', array(
            'rows' => 8,
            'class' => 'void',
            'title' => 'Сообщение',
            'style' => 'width:96%;',
            'placeholder' => 'Комментарий',
            'autocomplete' => 'off',
          ));
        ?>
        <?php echo $form->error($newComment, 'comment_text'); ?>
      </td>
    </tr>

    <?php if($this->useCaptcha === true && extension_loaded('gd')): ?>
    <tr>
      <td><?php echo $form->labelEx($newComment,'verifyCode'); ?></td>
      <td>
        <?php $this->widget('CCaptcha', array(
            'clickableImage' => true,
            'captchaAction'=>CommentsModule::CAPTCHA_ACTION_ROUTE,
        )); ?>
        <?php echo $form->textField($newComment, 'verifyCode', array('title' => 'Укажите код с картинки', 'autocomplete' => 'off')); ?>
            <?php echo $form->error($newComment, 'verifyCode', array(), true, false); ?>
      </td>
    </tr>
    <?php endif; ?>
    
    <tr>
      <td><img class="loader" src="<?php echo CHtml::asset($this->getAssetsPath().'/ajax-loader.gif'); ?>" style="display:none"></td>
      <td>
      <?php echo CHtml::htmlButton('Отправить', array('name' => 'btn', 'type' => 'submit', 'class' => 'button')); ?>
      </td>
    </tr>
  </table>
<?php $this->endWidget(); ?>
</div><!-- form -->
