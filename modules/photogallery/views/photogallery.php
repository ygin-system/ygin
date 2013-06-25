<?php
/*
  $currentGallery,
  $childGallery,
*/

$this->caption = $currentGallery->name;

$this->renderPartial('/photogallery_list', array(
  'childGallery' => $childGallery,
));

$this->widget('PhotogalleryWidget', array("model" => $currentGallery));
