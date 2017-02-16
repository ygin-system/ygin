<?php
class BannerJScriptWidget extends CWidget {
  /**
   * Идентификатор баннерного места
   * @var int
   */
  public $placeId;
  /**
   * Класс-отрисовщик баннерного места
   * @var string
   */
  public $placeClass = 'BannerPlaceWidget';
  /**
   * Карта связи идентификаторов баннерных мест и классов-отрисовщиков
   * @var array
   */
  public $bannerPlaceMap = array();
  /**
   * Ключ в карте связей
   * @var string
   */
  public $bannerPlaceKey;
  
  public function registerScript() {
    $loadBannersUrl = Yii::app()->createUrl(Yii::app()->getModule('banners')->loadBannersRoute);
    $js = CHtml::asset(Yii::getPathOfAlias('banners.components.assets').DIRECTORY_SEPARATOR.'banners.js');
    $cs = Yii::app()->clientScript;
    $cs->registerScriptFile($js);
    $cs->registerScript(__CLASS__, 'jQuery.getJSON("'.$loadBannersUrl.'", {bp:DaBp}, function(data) {if (data.length == 0) { return; } replaceBanners(data);});');
  }
  
  public function getReplaceContainerId() {
    return Yii::app()->getModule('banners')->getBannerReplaceContainerId($this->placeId);
  }
  
  public function init() {
    if ((empty($this->placeId) || empty($this->placeClass)) && !empty($this->bannerPlaceKey)) {
      if (!isset($this->bannerPlaceMap[$this->bannerPlaceKey])) {
        throw new CException('Key "'.$this->bannerPlaceKey.'" not exists in bannerPlaceMap.');
      }
      $val = $this->bannerPlaceMap[$this->bannerPlaceKey];
      if (is_int($val)) {
        $this->placeId = $val;
      } elseif (is_array($val) && count($val) == 2) {
        $this->placeId = $val[0];
        $this->placeClass = $val[1];
      } else {
        throw new CException('PlaceMap for key "'.$this->bannerPlaceKey.'" is invalid.');
      }
    }
    
    $this->registerScript();
  }
  
  public function run() {
    echo CHtml::tag('span', array('id' => $this->getReplaceContainerId()), '', true);
    echo CHtml::script('var DaBp = DaBp || []; DaBp.push('.CJavaScript::encode(array('id'=>$this->placeId, 'cls' => $this->placeClass)).');');
  }
  
}