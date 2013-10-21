<?php
  
  if (count($photos) > 0) {
    $this->registerCssFile('jquery-photowall.css');
    $this->registerJsFile('jquery-photowall.js');
    
    $data = array();
    $i = 0;
    foreach ($photos AS $photo) {
      $preview = $photo->getImagePreview('_list');
      if ($preview == null) continue;
      $i++;
      $previewSizes = getimagesize($preview->file_path);

      $data['photo'.$i] = array(
        'id' => 'photo'.$i,
        'img' => $photo->image->getUrlPath(),
        'width' => 500,
        'height' => 400,
        'title' => $photo->name,
        'th' => array(
          'src' => $preview->getUrlPath(),
          'width' => 50,
          'height' => 40,
          'previewWidth' => $previewSizes[0],
          'zoom_src' => $preview->getUrlPath(),
          'zoom_factor' => 2,
        ),
      );
    }

    $script = "        PhotoWall.init({
            el:             '.daGallery'               // Gallery element
            ,zoom:          true                     // Use zoom
            ,zoomAction:    'mouseenter'             // Zoom on action
            ,zoomTimeout:   500                      // Timeout before zoom
            ,zoomDuration:  100                      // Zoom duration time
            ,showBox:       true                     // Enavle fullscreen mode
            ,showBoxSocial: true                     // Show social buttons
            ,padding:       5                       // padding between images in gallery
            ,lineMaxHeight: 150                      // Max set height of pictures line
                                                     // (may be little bigger due to resize to fit line)
        });
        
        var photosArray = ".CJavaScript::encode($data).";

        PhotoWall.load(photosArray);
  ";
    Yii::app()->clientScript->registerScript('da_gal', $script, CClientScript::POS_READY);
?>
<div class="daGallery"> 
  <div class="body">
  </div> 
</div>
<?php }