<?php
class RandomPhotoWidget extends DaWidget  implements IParametersConfig {
  /**
   * @var int Ширина px
   */
  public $width = 100;
  /**
   * @var int Высота px
   */
  public $height = 100;
  /**
   * @var string Постфикс
   */
  public $postfix = '_rand';
  /**
   * @var int Качество
   */
  public $quality = 80;
  /**
   * @var mixed Тип кадрирования
   */
  public $cropType = null;
  /**
   * @var mixed Масштабирование
   */
  public $resize = false;

  public static function getParametersConfig() {
    return array(
      'width' => array(
        'type' => DataType::INT,
        'default' => 283,
        'label' => 'Ширина изображения (px)',
        'required' => true,
      ),
      'height' => array(
        'type' => DataType::INT,
        'default' => 205,
        'label' => 'Высота изображения (px)',
        'required' => true,
      ),
      'postfix' => array(
        'type' => DataType::VARCHAR,
        'default' => '_rand',
        'label' => 'Постфикс имен файлов',
        'required' => false,
      ),
      'quality' => array(
        'type' => DataType::INT,
        'default' => 80,
        'label' => 'Степень сжатия (%)',
        'required' => false,
      ),
      'cropType' => array(
        'type' => DataType::EVAL_EXPRESSION,
        'default' => 'null',
        'label' => 'Тип кадрирования',
        'required' => false,
      ),
      'resize' => array(
        'type' => DataType::EVAL_EXPRESSION,
        'default' => 'false',
        'label' => 'Масштабировать',
        'required' => false,
      ),
    );
  }
  
  
  public function run() {
    $model = PhotogalleryPhoto::model()->find(array('order' => 'RAND()'));
    //если фоток нет, то выходим
    if ($model == null) {
      return;
    }
    $preview = null;
    if ($model->image) {
      $preview = $model->image->getPreview(
        $this->width,
        $this->height,
        $this->postfix,
        $this->cropType,
        $this->quality,
        $this->resize
      );
    }
    $galleryLink = $photoLink = '#';
    if (Photogallery::model()->count() > 1) {
      $galleryLink = Yii::app()->createUrl(PhotogalleryModule::ROUTE_GALLERY_LIST);
    } else {
      $galleryLink = Yii::app()->createUrl(PhotogalleryModule::ROUTE_GALLERY_VIEW, array('idGallery' => $model->id_photogallery_instance));
    }
    if ($preview !== null) {
      $photoLink = Yii::app()->createUrl(PhotogalleryModule::ROUTE_GALLERY_VIEW, array('idGallery' => $model->id_photogallery_instance));
    }
    
    $this->render('randomPhoto', array(
      'photo' => $preview,
      'galleryLink' => $galleryLink,
      'photoLink' => $photoLink,
    ));
  }
}