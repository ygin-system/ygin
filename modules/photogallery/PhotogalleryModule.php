<?php

class PhotogalleryModule extends DaWebModuleAbstract {
  
  const ROUTE_GALLERY_VIEW = 'photogallery/photogallery/view';
  const ROUTE_GALLERY_LIST = 'photogallery/photogallery/index';
  
  protected $_urlRules = array(
    'photogallery' => self::ROUTE_GALLERY_LIST,
    'photogallery/<idGallery:\d+>' => self::ROUTE_GALLERY_VIEW,
  );
  
  public function init() {
    $this->setImport(array(
      'photogallery.behaviors.*',
      'photogallery.models.*',
      'photogallery.widgets.photogallery.PhotogalleryWidget',
    ));
    
  }

  public static function getDefaultConfig() {
    return array('modules' => array('ygin.photogallery'));
  }

}
