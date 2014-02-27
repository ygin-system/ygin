<?php

class BannerWidget extends DaWidget implements IParametersConfig {
  public $bannerPlaceId = Null;

	public function run() {
    if($this->bannerPlaceId) {
      $this->widget('ygin.modules.banners.components.BannerJScriptWidget', array(
        'placeId' => $this->bannerPlaceId,
      ));
    }
	}

  public static function getParametersConfig() {
    return array(
      'bannerPlaceId' => array(
        'type' => DataType::INT,
        'default' => 0,
        'label' => 'Ид баннерного места',
        'required' => true,
      ),
    );
  }

}
