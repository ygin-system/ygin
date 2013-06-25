<?php
class YginFileController extends DaBackendController {
  public function actions() {
    return array_merge(parent::actions(), array(
      'fileUpload' => array(
        'class' => 'fileUpload.FileUploadAction',
        'multiple' => false,
        'createThumb' => true,
        'thumbConfig' => array(
          'width' => 70,
          'height' => 50,
          'crop' => 'top',
          'postfix' => '_da',
        ),
      ),
      'listFileUpload' => array(
        'class' => 'fileUpload.FileUploadAction',
        'multiple' => true,
        'createThumb' => true,
        'rewriteIfFileExist' => false,
        'thumbConfig' => array(
          'width' => 70,
          'height' => 50,
          'crop' => 'top',
          'postfix' => '_da',
        ),
      ),
    ));
  }
}