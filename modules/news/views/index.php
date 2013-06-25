<?php

//Подключаем css
$this->registerCssFile('news.css');

if ($this->getModule()->showCategories) {
  $this->renderPartial('/_categories', array('categories' => $categories, 'activeCategory' => $category));
}

?>
<div class="b-news-list">
<?php foreach ($news as $model): ?>
<?php $this->renderPartial('/_list_item', array('model' => $model)); ?>
<?php endforeach; ?>
</div>

<?php  $this->widget('LinkPagerWidget', array(
  'pages' => $pages,
)); ?>


