<?php
class ImagePreviewBehavior extends CBehavior {

  /**
   * Форматы превьюх
   * Массив вида array(
   *               '_list' => array(
   *                 'width' => 130,
   *                 'height' => 100,
   *                 'crop' => 'center'
   *                 'quality' => 80,
   *                 'resize' => true,
   *               ),
   *               '_single' => array(
   *                 'width' => 100,
   *                 'quality' => 100,
   *                 'resize' => true,
   *               ),
   *             )
   * где ключами выступают постфиксы превьюх
   * @property array
   */
  public $formats = array();
  
  public $defaultWidth = null;
  public $defaultHeight = null;
  public $defaultCrop = null;
  public $defaultQuality = 90;
  public $defaultResize = false;
  
  
  /**
   * Свойство по-умолчанию для которого будут делаться превью
   * @property string
   */
  public $imageProperty = 'image';
  
  
  public function getImagePreview($postfix, $property = null) {
  	
    if ($property === null) {
      $property = $this->imageProperty;
    }
    $format = HArray::val($this->formats, $postfix, null);
    if ($format === null) {
      return null;
    }
    
    $width = HArray::val($format, 'width', $this->defaultWidth);
    $height = HArray::val($format, 'height', $this->defaultHeight);
    $crop = HArray::val($format, 'crop', $this->defaultCrop);
    $quality = HArray::val($format, 'quality', $this->defaultQuality);
    $resize = HArray::val($format, 'resize', $this->defaultResize);

    if ($this->owner->$property !== null) {
	    return $this->owner->$property->getPreview($width, $height, $postfix, $crop, $quality, $resize);
	  }
	  return null;
  }
}
