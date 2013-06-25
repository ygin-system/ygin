<?php
class BannersModule extends DaWebModuleAbstract {
  /**
   * Интервал в милисекундах, после которого начнется пост загрузка баннеров. 
   * @var int
   */
  public $postLoadInterval = 0;
  
  /**
   * Определяет нужно ли считать количество показов
   * @var boolean
   */
  public $viewStatisticAvailable = false;
  
  /**
   * Префикс контейнера, который будет заменен баннерным местом
   * @var string
   */
  public $replaceContainerPrefix = 'id_banner_place_';
  /**
   * Путь формате alias к виджетам, которые рисуют баннерное место
   * @var string
   */
  public $bannersWidgetsPath = 'banners.components';
  /**
   * Действие, которое возвращает JSON с баннерными местами
   * @var string
   */
  public $loadBannersRoute = '/banners/default/index';

  protected $_urlRules = array(
    'rklm-cl/<unicName:.+>' => 'banners/default/click',
    'rklm-sh/<unicName:.+>' => 'banners/default/show',
  );

  public function getBannerReplaceContainerId($idBannerPlace) {
    return $this->replaceContainerPrefix.$idBannerPlace;
  }
  
  public function getVersion() {
    return '0.0.1';
  }
  
  public function loadApplicationModules() {
  }
  
  public function init() {
    $this->setImport(array(
      $this->id.'.models.*',
      $this->id.'.components.*',
    ));
    
  }

}
