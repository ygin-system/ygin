<?php
class SpecialOfferWidget extends BannerPlaceWidget implements IParametersConfig {

  public $idBannerPlace = 1;
  private $_bannerPlace = null;

  public static function getParametersConfig() {
    return array(
      'idBannerPlace' => array(
        'type' => DataType::INT,
        'default' => null,
        'label' => 'ИД баннерного места',
        'required' => true,
      ),
    );
  }

  public function getBannerPlace() {
    if ($this->_bannerPlace != null)
      return $this->_bannerPlace;
    $this->_bannerPlace = BannerPlace::model()->findByPk($this->idBannerPlace);
    return $this->_bannerPlace;
  }

  public function init() {
    $criteria = new CDbCriteria();
    $criteria->order = 'sequence';
    $criteria->addColumnCondition(array('id_banner_place' => $this->idBannerPlace));
    $this->banners = Banner::model()->with('bannerFile')->findAll($criteria);
    parent::init();
  }
  
  public function renderTop() {
    echo CHtml::openTag("ul", array('class' => 'thumbnails'));
  }
  
  public function renderItem(Banner $banner, $index) {
    // пока рисуем только 4 баннера
//    if ($index > 3) return;
    // флэш баннеры пропускаем
    if ($banner->isFlash()) return;
    
    echo CHtml::openTag("li", array("class" => 'span3'));
    echo $this->getImageBanner($banner, $this->bannerPlace->width, $this->bannerPlace->height);
    echo CHtml::closeTag("li");
  }
  protected function getImageBanner(Banner $banner, $width=null, $height=null) {
    $clickUrl = $banner->getClickUrl();
    $htmlOptions = array("class" => 'thumbnail');
    if ($width != null) $htmlOptions['width'] = $width;
    if ($height != null) $htmlOptions['height'] = $height;
    $htmlOptions = array('width' => $width, 'height' => $height);
    
    $code = CHtml::image($banner->getShowUrl(), $banner->alt, $htmlOptions);
    $code .= CHtml::openTag("div", array("class" => 'caption')).CHtml::tag("h5", array(), $banner->alt, true).CHtml::closeTag("div");
    if (($link = $banner->link) != null && $link != 'http://') {
      $link = "#";
    }
    $code = CHtml::link(
        $code, 
        $clickUrl, 
        array(
          'title' => $banner->alt,
          'class' => 'thumbnails'
          //'target' => $banner->in_new_window == 1 ? '_blank' : '_self',
        )
    ); 
    return $code;    
  }
  public function renderBottom() {
    echo CHtml::closeTag('ul');
  }
  
  // зануляем
  public function renderTopItem(Banner $banner, $index) {
  }
  public function renderBottomItem(Banner $banner, $index) {
  }
  
}