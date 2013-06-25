<?php
foreach ($this->getFiles() as $file) {
  if ($file->getIsImage()) {
    if ($prev = $file->getPreview(70, 50, 'top', '_da')) {
      echo CHtml::link(CHtml::image($prev->getUrlPath(), 'Превью', array('class' => 'img-polaroid')),
        $file->getUrlPath(),
        array('rel' => 'gallery'.$this->getObjectParameter()->id_parameter)
      );
    } else {
      echo CHtml::link($file->getName(), $file->getUrlPath());
    }
  } else {
    echo CHtml::link($file->getName(), $file->getUrlPath());
  }
}