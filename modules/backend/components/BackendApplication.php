<?php

require_once dirname(__FILE__).'/../../../components/BaseApplication.php';

/**
 * BackendApplication
 *
 * The followings are the available component:
 * @property DaDomain $domain
 * @property DaMenu $menu
 */
class BackendApplication extends BaseApplication {

  const EVENT_ON_YIIGIN_MESSAGE = 'onBackendMessage';

  const MESSAGE_TYPE_INFO = 'info';
  const MESSAGE_TYPE_ERROR = 'error';
  const MESSAGE_TYPE_SUCCESS = 'success';

  public $isBackend = true;

  private $_frontendConfig = null;

  public function getFrontendConfig() {
    if ($this->_frontendConfig === null) {
      $this->_frontendConfig = require(Yii::getPathOfAlias('ygin.config.mainConfig').'.php');
    }
    return $this->_frontendConfig;
  }

  /**
   * @return CTheme|mixed
   */
  public function getFrontendTheme() {
    $theme = HArray::val($this->getFrontendConfig(), 'theme');
    if ($theme != null) {
      return $this->themeManager->getTheme($theme);
    }
    return $theme;
  }

  public function addMessage($message, $type=self::MESSAGE_TYPE_INFO, $sticked=false, $time=5) {
    $this->raiseEvent(self::EVENT_ON_YIIGIN_MESSAGE, new MessageEvent($this, $message, $type, $sticked, $time));
  }
  public function hasEvent($name) {
    return true;
  }

}