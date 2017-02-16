<div class="item">
  <span class="date label label-default"><?php echo Yii::app()->dateFormatter->format('dd MMMM yyyy', $data->create_date); ?></span>
  <div class="name"><?php echo CHtml::encode($data->name); ?></div>
  <div class="ask">
    <?php echo nl2br(CHtml::encode($data->review)); ?>
  </div>
</div>