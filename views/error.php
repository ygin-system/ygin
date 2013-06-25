<?php
$this->pageTitle=Yii::app()->name . ' - Error';
?>

<h2>Error <?php echo $code; ?></h2>

<div class="alert alert-error">
<?php echo CHtml::encode($message); ?>
</div>