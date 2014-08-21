<div id="page_wrap">
  <?php
  $this->registerCssFile('gallery.css');
  $this->registerJsFile('gallery.js');
  
  foreach ($childGallery AS $gallery) {
    $cssClass = 'image_stack';
    if ($gallery->countPhoto == 1) $cssClass = 'single_photo';
    $photos = $gallery->photosList(array('limit' => 3));
  ?>
    <div class="<?php echo $cssClass; ?>">
    <?php
    $photoNum = 0;
    $link = $gallery->getUrl();
    foreach ($photos AS $photo) {
      $photoNum++;
      $smallImage = $photo->image->getPreview($w=220, $h=220, $postfix = '_gal', $cropType = null, $quality = 90, $resize = false);
      if ($smallImage == null) continue;
      
      if ($gallery->countPhoto == 1) { ?>
      <ul id="pics">
        <li><a href="<?php echo $link; ?>" title="Photo"><img src="<?php echo $smallImage->getUrlPath(); ?>" alt=""></a></li>
      </ul>
      <?php } else { ?>
      <a href="<?php echo $link; ?>" title="Photo"><img class="photo<?php echo $photoNum ?> stackphotos" src="<?php echo $smallImage->getUrlPath(); ?>" ></a>
      <?php }
    }
    // выводим имя галереи и кол-во фоток
    echo '<div class="info">'.HText::smartCrop($gallery->name, 85)." (".$gallery->countPhoto.')</div>';
    ?>
    </div>
  <?php } ?>
</div>
