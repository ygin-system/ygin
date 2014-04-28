<h1>Экспорт объекта</h1>
<?php
  $form = $this->beginWidget('CActiveForm', array(
    'method' => 'post',
    'id' => 'export-object-form',
    'enableClientValidation' => true,
    'enableAjaxValidation' => false,
    'clientOptions' => array(
      'validateOnSubmit' => true,
      'validateOnChange' => false,
    ),
    'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
  ));
?>
<fieldset>
  <div><?= $form->errorSummary($model); ?></div>
  <div class="form-group objects">
    <?php echo $form->labelEx($model, 'objectId'); ?>
    <?php
      echo $form->dropDownList(
        $model,
        'objectId',
        CHtml::listData($objects, 'id_object', 'name'),
        array(
          'empty' => 'Выберите клонируемый объект',
          'class' => 'form-control',
          'ajax' => array(
            'type' => 'GET',
            'url' => Yii::app()->createUrl('objectExport/default/objectParameters'),
            'update' => '.object-parameters',
            'data' => array('objectId' => 'js:this.value'),
          )
        )
      ); ?>
    <?php echo $form->error($model, 'objectId'); ?>
  </div>

  <div class="form-group object-parameters col-lg-12"></div>

  <div class="form-group">
    <?= $form->textField($model, "objectName", array('placeholder' => 'Название объекта', 'class' => 'form-control')); ?>
    <?= $form->error($model, "objectName"); ?>
  </div>

  <div class="form-group">
    <?= $form->textField($model, "tableName", array('placeholder' => 'Название таблицы', 'class' => 'form-control')); ?>
    <?= $form->error($model, "tableName"); ?>
  </div>

  <div class="checkbox">
    <?= $form->checkBox($model, "isDataExport", array()); ?> Экспорт данных
  </div>

  <?/*
  <div class="checkbox">
    <?= $form->checkBox($model, "isPermissionExport", array()); ?> Экспорт прав доступа к объекту
  </div>
*/ ?>
  <div class="row">
    <button name="submit" type="submit" class="btn btn-primary">Экспорт</button>
  </div>

</fieldset>
<?php
  $this->endWidget();
?>