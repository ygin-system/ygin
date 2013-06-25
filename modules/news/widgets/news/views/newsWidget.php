<?php
$this->registerCssFile('newsWidget.css');
?>
<div class="b-news-widget">
  <h2>Новости</h2>
  <?php
  //если нужно брать переопределенное представление элемента списка из темы,
  //то вместо news.views._list_item нужно прописать
  //webroot.themes.название_темы.views.news._list_item
  ?>
<?php foreach ($this->getNews() as $model): ?>
<?php $this->render('news.views._list_item', array('model' => $model)); ?>
<?php endforeach; ?>
<div class="archive"><a href="<?php echo Yii::app()->createUrl(NewsModule::ROUTE_NEWS_CATEGORY);?>">Все новости &nbsp;»</a></div>
</div>