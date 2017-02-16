<?php
class BannerPlaceWidget extends DaWidget {
  /**
   * Задержка с которой будет отрисовываться каждый баннер в миллисекундах
   * @var int
   */
  protected static $interval;
  /**
   * Баннеры баннерного места
   * @var Banner array
   */
  public $banners = array();
  /**
   * Контейнер, который будет заменен кодом конкретного баннера
   * @var string 
   */
  public $itemReplaceWrapper = 'div';
  /**
   * Массив с кодом конкрентных баннеров для замены
   * @var array
   */
  protected  $bannersReplacementCode = array();
  /**
   * Брать размер баннеров из баннерного места.
   * @var boolean
   */
  public $sizeFromBannerPlace = false;
  
  public function init() {
    parent::init();
    self::$interval = (int)Yii::app()->getModule('banners')->postLoadInterval;
  }
  
  public function getBannerReplacementCode() {
    return $this->bannersReplacementCode;
  }
  
  protected function addBannersReplacementCode(Banner $banner, $code) {
    
    $scr = '';
    $id = $this->getReplaceContainerId($banner);
    
    if (self::$interval < 15) {
      $this->bannersReplacementCode[] = array('id' => $id, 'code' => $code, 'interval' => 0);
    } else {
      $this->bannersReplacementCode[] = array('id' => $id, 'code' => $code, 'interval' => self::$interval);
      self::$interval += self::$interval;
    }
    
  }
  
  public function renderTop() {
    
  }
  
  public function renderTopItem(Banner $banner, $index) {
    echo CHtml::openTag('div');
  }
  
  public function renderItem(Banner $banner, $index) {
    $id = $this->getReplaceContainerId($banner);
    if (($size = $this->getFileSize($banner)) === false) {
      return ;
    }
     
    echo CHtml::openTag($this->itemReplaceWrapper, array('id' => $id));
    
    $code = '';
    if ($banner->isFlash()) {
      $code = $this->getFlashBanner($banner, $size[0], $size[1]);
    } elseif ($banner->isImage()) {
      $code = $this->getImageBanner($banner, $size[0], $size[1]);
    }
    
    $this->addBannersReplacementCode($banner, $code);

    echo CHtml::closeTag($this->itemReplaceWrapper);
  }
  
  public function renderBottomItem(Banner $banner, $index) {
    echo CHtml::closeTag('div');
  }
  
  public function renderBottom() {
    
  }
  
  protected function getFileSize(Banner $banner) {
    $size = array();
    if ($this->sizeFromBannerPlace) {
      $bp = $banner->bannerPlace;
      $size = array($bp->width, $bp->height);
    } else {
      $file = $banner->bannerFile;
      $filePath = $file->getFilePath(true);
      if (!file_exists($filePath) || !($size = getimagesize($filePath))) {
        Yii::log('Ошибка получения размеров файла "'.$filePath.'"', CLogger::LEVEL_WARNING, 'application.modules.banners');
        return false;
      }
    }

    
    return $size;
  }
  
  protected function getFlashBanner(Banner $banner, $width, $height) {
    $showUrl = $banner->getShowUrl();
    return '<object type="application/x-shockwave-flash" data="'.$showUrl.'" width="'.$width.'" height="'.$height.'" align="middle">
               <param name="wmode" value="opaque"></param>
               <param name="movie" value="'.$showUrl.'"></param>
               <param name="allowScriptAccess" value="always"></param>
               <param name="quality" value="high"></param>
               <param name="bgcolor" value="#fff"></param>
               <embed wmode="opaque" src="'.$showUrl.'" type="application/x-shockwave-flash" allowscriptaccess="always" width="'.$width.'" height="'.$height.'"></embed>
            </object>';
  }
  
  protected function getImageBanner(Banner $banner, $width=null, $height=null) {
    $clickUrl = $banner->getClickUrl();
    $htmlOptions = array();
    if ($width != null) $htmlOptions['width'] = $width;
    if ($height != null) $htmlOptions['height'] = $height;
    $htmlOptions = array('width' => $width, 'height' => $height);
    
    $code = CHtml::image($banner->getShowUrl(), $banner->alt, $htmlOptions);
    if (($link = $banner->link) != null && $link != 'http://') {
      $code = CHtml::link(
        $code, 
        $clickUrl, 
        array(
          'title' => $banner->alt,
        )
      ); 
    }
    return $code;    
  }
  
  protected function getReplaceContainerId(Banner $banner) {
    return 'bnr_rpl_'.$banner->id_banner;
  }
  
  
  public function run() {
    if (empty($this->banners)) {
      return;
    }
    $this->renderTop();
    $count = count($this->banners);
    
    for ($i = 0; $i < $count; $i++) {
      $banner = $this->banners[$i];
      $this->renderTopItem($banner, $i);
      $this->renderItem($banner, $i);
      $this->renderBottomItem($banner, $i);      
    }
    
    $this->renderBottom();
    
  }
}