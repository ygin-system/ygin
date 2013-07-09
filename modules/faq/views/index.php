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
        'class' => 'form-horizontal ask-form',
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
<fieldset>
    <legend style='border: 0'>
        Задать вопрос
    </legend>
    <?php if ($model->hasErrors()):
        ?>
        <div class="alert alert-error input-xxlarge">
            <?php echo CHtml::errorSummary($model); ?>
        </div>
    <?php endif; ?>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'name', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'name', array('class' => 'input-xlarge')); ?>
            <?php echo $form->error($model, 'name'); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'email', array('class' => 'control-label')); ?>
        <div class="controls">
            <!-- +not-encode-mail -->
            <?php echo $form->textField($model, 'email', array('class' => 'input-xlarge')); ?>
            <!-- -not-encode-mail -->
            <?php echo $form->error($model, 'email'); ?>
        </div>
    </div>
    <?php if (Yii::app()->getModule('faq')->useCategories == true): ?>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'category', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'category', $model->categoriesList(), array('class' => 'input-xlarge')); ?>
            <?php echo $form->error($model, 'category'); ?>
        </div>
    </div>
    <?php endif; ?>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'question', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textArea($model, 'question', array('class' => 'input-xxlarge', 'style' => 'height: 70px;')); ?>
            <?php echo $form->error($model, 'question'); ?>
        </div>
    </div>
    <?php if(extension_loaded('gd') && Yii::app()->user->isGuest): ?>
        <div class="control-group">
            <?php echo CHtml::activeLabelEx($model, 'verifyCode', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php $this->widget('CCaptcha', array('clickableImage'=>true, 'showRefreshButton'=>false)); ?>
                <?php echo CHtml::activeTextField($model, 'verifyCode', array('autocomplete' => 'off')); ?>
                <?php echo $form->error($model, 'verifyCode'); ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="form-actions">
        <?php echo CHtml::submitButton('Отправить', array('class' => 'btn btn-success')); ?>
    </div>
</fieldset>
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