<?php
/* @var $this DefaultController */

$this->caption = 'Экспорт моделей';

?>

<?php 
$form = $this->beginWidget('CActiveForm', array(
));
?>
 <fieldset>
  <div class="form-group">
    <label class="control-label col-lg-4" for="inputEmail">Email</label>
    <div class="controls col-lg-8">
    <?php echo $form->dropDownList($model, 'objectId', CHtml::listData($objects, 'id_object', 'name'), array('class' => 'form-control')); ?>
    </div>
  </div>
  <div class="form-actions">
    <button type="submit" class="btn btn-primary">Экспорт</button>
  </div>
</fieldset>
<?php 
$this->endWidget();
?>