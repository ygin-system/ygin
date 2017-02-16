<?php
$this->registerCssFile('review.css');

if (Yii::app()->user->hasFlash('reviewAdd')) {
  $this->widget('AlertWidget', array(
    'title' => 'Отзывы',
    'message' => Yii::app()->user->getFlash('reviewAdd'),
  ));
}

?>
<div class="b-review">

<?php
$form = $this->beginWidget('CActiveForm', array(
    'htmlOptions' => array(
        'class' => 'ask-form',
        //'autocomplete' => 'off',
    ),
    'enableClientValidation' => true,
    'enableAjaxValidation' => false,
    'clientOptions' => array(
      'validateOnSubmit' => true,
      'validateOnChange' => false,
    ),
    //'focus' => array($model, 'name')
  ));
?>
    <h3>Отправить отзыв</h3>
    <?php if ($model->hasErrors()):
        ?>
        <div class="alert alert-danger input-xxlarge">
            <?php echo CHtml::errorSummary($model); ?>
        </div>
    <?php endif; ?>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'name', array('class' => 'control-label')); ?>
            <div>
                <?php echo $form->textField($model, 'name', array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </div>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'contact', array('class' => 'control-label')); ?>
        <div>
            <?php echo $form->textField($model, 'contact', array('class' => 'form-control')); ?>
            <?php echo $form->error($model, 'contact'); ?>
        </div>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'review', array('class' => 'control-label')); ?>
        <div>
            <?php echo $form->textArea($model, 'review', array('class' => 'form-control')); ?>
            <?php echo $form->error($model, 'review'); ?>
        </div>
    </div>
    <?php if(extension_loaded('gd') && Yii::app()->user->isGuest): ?>
        <div class="form-group">
            <?php echo CHtml::activeLabelEx($model, 'verifyCode', array('class' => 'control-label')); ?>
            <div>
                <?php $this->widget('CCaptcha', array('clickableImage'=>true, 'showRefreshButton'=>false)); ?>
                <?php echo CHtml::activeTextField($model, 'verifyCode', array('autocomplete' => 'off')); ?>
                <?php echo $form->error($model, 'verifyCode'); ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="form-group">
        <?php echo CHtml::submitButton('Отправить', array('class' => 'btn btn-default')); ?>
    </div>
<?php $this->endWidget('CActiveForm'); ?>

<?php
$this->widget('zii.widgets.CListView', array(
    'itemView' => 'review.views._item',
    'dataProvider' => $dataProvider,
    'emptyText' => '',
    'pager' => array('class' => 'LinkPagerWidget'),
    'pagerCssClass' => 'dummyClass', //Если класс оставить пустым то происходит ошибка в плагине yiiListView
    'summaryText' => '',
));
?>
</div>