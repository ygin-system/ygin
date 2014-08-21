<?php 
$this->registerCssFile('photogallery-random-widget.css');
?>
<div class="b-photogallery-random-widget">
  <?php if ($photo): ?>
  <a href="<?=$photoLink?>"><img src="<?=$photo->getUrlPath()?>"></a>
  <?php endif; ?>
  <a class="btn btn-xs photogallery-link" href="<? echo $galleryLink ?>">Фотогалерея »</a>
</div>