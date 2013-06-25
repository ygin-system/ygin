<?php
//TODO Иванычу сверстать
Yii::app()->clientScript->registerCss("view.list-file", "
  .controls .list-file {list-style:none; padding:0; margin:0;}
  .controls .list-file li {float:left; margin-left: 20px; height:80px;}
  .controls .list-file li:first-child {margin-left: 0;}
");

if (count($files = $this->getFiles()) > 0) {
  echo CHtml::openTag('ul', array('class' => 'list-file'));
  foreach ($this->getFiles() as $file) {
    echo CHtml::openTag('li');
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
    echo CHtml::closeTag('li');
  }
  echo CHtml::closeTag('ul');
}