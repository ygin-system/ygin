<?php

require_once dirname(__FILE__).'/BaseApplication.php';

/**
 * DaWebApplication
 *
 * The followings are the available component:
 * @property DaDomain $domain
 * @property DaMenu $menu
 */
class DaWebApplication extends BaseApplication {

  public $isFrontend = true;
  
}