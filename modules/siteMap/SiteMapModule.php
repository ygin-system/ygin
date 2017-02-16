<?php
class SiteMapModule extends DaWebModuleAbstract {
  const ROUTE_SITE_MAP = 'siteMap/default/index';
  
  protected $_urlRules = array(
    'map' => self::ROUTE_SITE_MAP,
  );
  
  public function init() {
    parent::init();
    $this->setImport(array(
      $this->getId().'.controllers.*',
    ));
  }
}