<?php
$this->registerCssFile('faq.css');
$this->registerJsFile('faq.js');
Yii::app()->clientScript->registerScript('faq.init', 'FAQ.init();', CClientScript::POS_READY);

if (Yii::app()->user->hasFlash('questionAdd')) {
  $this->widget('AlertWidget', array(
    'title' => 'Вопрос-ответ',
    'message' => Yii::app()->user->getFlash('questionAdd'),
  ));
}

?>
<div class="b-faq">

<?php
$form = $this->beginWidget('CActiveForm', array(
    'htmlOptions' => array(
        'class' => 'ask-form',
        //'autocomplete' => 'off',
    ),
    'enableAjaxValidation' => true,
    'clientOptions' => array(
      'validateOnSubmit' => true,
      'validateOnChange' => false,
    ),
    //'focus' => array($model, 'name')
  ));
?>
    <h3>Задать вопрос</h3>
    <?php if ($model->hasErrors()):
        ?>
            <div class="alert alert-danger form-control">
            <?php echo CHtml::errorSummary($model); ?>
        </div>
    <?php endif; ?>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'name'); ?>
            <?php echo $form->textField($model, 'name', array('class' => 'form-control')); ?>
            <?php echo $form->error($model, 'name'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'email'); ?>
            <!-- +not-encode-mail -->
            <?php echo $form->textField($model, 'email', array('class' => 'form-control')); ?>
            <!-- -not-encode-mail -->
            <?php echo $form->error($model, 'email'); ?>
    </div>
    <?php if (Yii::app()->getModule('faq')->useCategories == true): ?>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'category'); ?>
            <?php echo $form->dropDownList($model, 'category', $model->categoriesList(), array('class' => 'form-control')); ?>
            <?php echo $form->error($model, 'category'); ?>
    </div>
    <?php endif; ?>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'question'); ?>
            <?php echo $form->textArea($model, 'question', array('class' => 'form-control', /*'style' => 'height: 70px; width: 420px;'*/)); ?>
            <?php echo $form->error($model, 'question'); ?>
    </div>
    <?php if(extension_loaded('gd') && Yii::app()->user->isGuest): ?>
        <div class="form-group">
            <?php echo CHtml::activeLabelEx($model, 'verifyCode'); ?>
                <?php $this->widget('CCaptcha', array('clickableImage'=>true, 'showRefreshButton'=>false)); ?>
                <?php echo CHtml::activeTextField($model, 'verifyCode', array('autocomplete' => 'off')); ?>
                <?php echo $form->error($model, 'verifyCode'); ?>
        </div>
    <?php endif; ?>
        <?php echo CHtml::submitButton('Отправить', array('class' => 'btn btn-default')); ?>
<?php $this->endWidget('CActiveForm'); ?>

<?php
$this->widget('zii.widgets.CListView', array(
    'itemView' => 'faq.views._item',
    'dataProvider' => $dataProvider,
    'emptyText' => '',
    'pager' => array('class' => 'LinkPagerWidget'),
    'pagerCssClass' => 'pagination pagination-small pagination-container',
    'summaryText' => '',
));
?>
</div>