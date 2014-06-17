<?php $this->registerCssFile('vitrine.css');?>

<div id="ygin-vitrine-carousel" class="b-vitrine carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
<?php 
$i = 0;
foreach ($models AS $model) {
  $activeClass = ($i == 0) ? ' class="active"' : '';

?>
  <li data-target="#ygin-vitrine-carousel" data-slide-to="<?php echo $i ?>"<?php echo $activeClass ?>></li>
<?php
  $i++;
}
?>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner">
<?php
$i = 0;
foreach ($models AS $model) {
  $id    = $model->id_vitrine;
  $class = ($i == 0) ? 'item active' : 'item';
  $link  = $model->link;
  $imgHTML = '';
  if ($model->file) {
    $imgHTML = '<img src="'.$model->file->getUrlPath().'" alt="'.$model->title.'">';
  } else {
    $imgHTML = '<div class="img"></div>';
  }
?>
    <div class="<? echo $class ?>">
      <?php echo $imgHTML ?>
      <div class="carousel-caption">
        <h3 class="title"><a href="<?php echo $link; ?>"><?php echo $model->title; ?></a></h3>
        <div class="text"><?php echo $model->text; ?></div>
      </div>
    </div>
<?php
  $i++;
}
?>
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#ygin-vitrine-carousel" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#ygin-vitrine-carousel" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
  </a>
</div>