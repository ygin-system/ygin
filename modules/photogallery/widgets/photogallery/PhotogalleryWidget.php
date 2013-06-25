<?php
class PhotogalleryWidget extends DaWidget {
  
  public $model = null;
  
  public function run() {
    if ($this->model == null) throw new ErrorException("Для виджета PhotogalleryWidget не установлена модель");
    
    $ass = $this->getAssetsPath();
    Yii::app()->clientScript->addDependResource('jquery-photowall.css', array(
      $ass.'exit.gif',
      $ass.'loader.gif',
      $ass.'lock.gif',
//      $ass.'lll.png',
//      $ass.'lrr.png',
    ));
    
//    $photos = PhotogalleryPhoto::model()->with('image')->byInstance($this->model)->findAll();
    $photos = $this->model->photosList;
    $this->render('photogallery', array(
      'photos' => $photos,
    ));
  }
}
