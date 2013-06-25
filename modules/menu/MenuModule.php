<?php

class MenuModule extends DaWebModuleAbstract {

  const ROUTE_STATIC_MENU = 'static/page';
  const ROUTE_STATIC_MENU_PARAM = 'view';

  public $urlRules = array(
      'page/<view:[\w\.\-\_]+>' => self::ROUTE_STATIC_MENU, // Правило для статических разделов
  );
  
  public function init() {
    $this->setImport(array(
      'menu.models.*',
      'menu.components.*',
      'menu.widgets.*',
    ));
  }

}
