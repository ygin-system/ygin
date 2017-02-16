<div class="item">
  <span class="date label label-default"><?php echo Yii::app()->dateFormatter->format('dd MMMM yyyy', $data->ask_date); ?></span>
  <div class="name"><?php echo CHtml::encode($data->name); ?></div>
  <div class="ask">
    <?php echo nl2br(CHtml::encode($data->question)); ?>
  </div>
<?php if ($data->answer){ ?>
  <div class="ans">
    <?php echo $data->answer; ?>
  </div>
<?php } ?>
</div>