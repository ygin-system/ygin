<?php
/* @var $this DefaultController */

$this->caption = 'Экспорт моделей';

?>

<?php 
$form = $this->beginWidget('CActiveForm', array(
));
?>
 <fieldset>
  <div class="control-group">
    <label class="control-label" for="inputEmail">Email</label>
    <div class="controls">
    <?php echo $form->dropDownList($model, 'objectId', CHtml::listData($objects, 'id_object', 'name')); ?>
    </div>
  </div>
  <div class="form-actions">
  <button type="submit" class="btn btn-primary">Экспорт</button>
</div>
</fieldset>
<?php 
$this->endWidget();
?>