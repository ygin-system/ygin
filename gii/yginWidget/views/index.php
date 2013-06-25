<h1>Widget Generator</h1>

<p>Генератор поможет создать каркас виджета</p>

<?php $form=$this->beginWidget('CCodeForm', array('model'=>$model)); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'widgetClass'); ?>
		<?php echo $form->textField($model,'widgetClass',array('size'=>65)); ?>
		<div class="tooltip">
		
		</div>
		<?php echo $form->error($model,'widgetClass'); ?>
	</div>
  <div class="row">
		<?php echo $form->labelEx($model,'widgetPath'); ?>
		<?php echo $form->textField($model,'widgetPath',array('size'=>65)); ?>
		<div class="tooltip">
		
		</div>
		<?php echo $form->error($model,'widgetPath'); ?>
	</div>
  <div class="row sticky">
		<?php echo $form->labelEx($model,'baseClass'); ?>
		<?php echo $form->textField($model,'baseClass',array('size'=>65)); ?>
		<div class="tooltip">
		
		</div>
		<?php echo $form->error($model,'baseClass'); ?>
	</div>
<?php $this->endWidget(); ?>
