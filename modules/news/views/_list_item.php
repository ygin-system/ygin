<div class="item">
  <div class="date"><?php echo Yii::app()->dateFormatter->format(Yii::app()->getModule('news')->getListDateFormat(), $model->date); ?></div>
  <h3><?php echo CHtml::link($model->title, $model->getUrl()); ?></h3>
  <?php if (($preview = $model->getImagePreview('_list')) !== null): ?>
    <div class="photo">
      <?php echo CHtml::link(CHtml::image($preview->getUrlPath(), $model->title), $model->getUrl(), array('title' => $model->title)); ?>
    </div>
  <?php endif; ?>
  <div class="text"><?php echo $model->short; ?></div>
  <div class="more"><?php echo CHtml::link('Полный текст', $model->getUrl()); ?> »</div>
</div>