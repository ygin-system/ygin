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

  private $_baseUrl = null;

  public function generateFrontedUrl() {
    $this->_baseUrl = $this->urlManager->baseUrl;
    $this->urlManager->baseUrl = '';
  }
  public function generateBackendUrl() {
    $this->urlManager->baseUrl = $this->_baseUrl;
  }

  public function addMessage($message, $type=self::MESSAGE_TYPE_INFO, $sticked=false, $time=5) {
    $this->raiseEvent(self::EVENT_ON_YIIGIN_MESSAGE, new MessageEvent($this, $message, $type, $sticked, $time));
  }
  public function hasEvent($name) {
    return true;
  }

}