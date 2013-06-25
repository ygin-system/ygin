<?php

class PhotogalleryController extends Controller {
  
  protected $urlAlias = "photogallery";
  
  public function actionIndex() {
    // список галерей первого уровня. Всегда первого уровня
    $childGallery = Photogallery::model()->byParent(null)->with('countPhoto')->findAll();
    $this->render('/photogallery_list', array(
      'childGallery' => $childGallery,
    ));
  }
  
  public function actionView($idGallery) {
    $currentGallery = $this->loadModelOr404('Photogallery', $idGallery);
    $childGallery = Photogallery::model()->byParent($currentGallery->id_photogallery)->with('countPhoto')->findAll();
    
    $arr = array();
    $tmp = $currentGallery;
    while($tmp != null) {
      $arr[$tmp->name] = $tmp->getUrl();
      $tmp = $tmp->getParent();
    }
    if (count($arr) > 0) {
      $this->breadcrumbs = array_merge($this->breadcrumbs, array_reverse($arr));
    }
    
    $this->render('/photogallery', array(
      'currentGallery' => $currentGallery,
      'childGallery' => $childGallery,
    ));
    
  }
  
}