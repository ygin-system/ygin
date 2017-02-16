<?php $this->caption = 'Распределение товаров'; ?>
<ul class="inline">
  <?php foreach ($rootCategories as $cat): ?>
    <li>
      <?php $class = ($cat->primaryKey == $idCategory) ? 'muted' : ''; ?>
      <?php echo CHtml::link($cat->name, Yii::app()->createUrl('shop/product/distribution', array('idCategory' => $cat->primaryKey)), array('class' => $class)); ?>
    </li>
  <?php endforeach; ?>
</ul>
<button class="btn check-all" style="margin-bottom: 10px;">Отметить все</button>
<form method="post">
  <ul class="media-list">
    <?php foreach ($models as $key => $model): ?>
      <li class="media">
        <?php if ($model->image): ?>
          <a class="pull-left">
            <img class="media-object" src="<?php echo $model->getImagePreview('_dist')->getUrlPath(); ?>">
          </a>
        <?php endif; ?>
        <div class="media-body" style="height: 100px;">
          <label class="checkbox">
            <input type="checkbox" name="Product[<?php echo $key; ?>][save]"><?php echo $model->name; ?>
          </label>
          <input name="Product[<?php echo $key; ?>][id]" value="<?php echo $model->primaryKey; ?>" type="hidden">
        </div>
        <hr>
      </li>
    <?php endforeach; ?>
  </ul>
  <?php echo $data; ?>
  <br>
  <button type="submit" class="btn">Перенести отмеченные товары в выбранную категорию</button>
</form>
<?php if ($pages): ?>
  <?php
  $this->widget('CLinkPager', array(
      'pages' => $pages,
  ))
  ?>
<?php endif; ?>
<script>
  $(document).ready(function(){
    $('.check-all').on('click', function(){
      $('[type=checkbox]').prop('checked', true);
    });
  });
</script>