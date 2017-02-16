<?php
class BackendUrlManager extends CUrlManager {
  /**
   * Позволяет генерировать ссылки без префикса /admin
   * @var bolean
   */
  private $_frontendMode = false;
  public function setFrontendMode($mode) {
    $this->_frontendMode = $mode;
  }
  public function getFrontendMode() {
    return $this->_frontendMode;
  }
  public function createUrl($route,$params=array(),$ampersand='&') {
    $url = parent::createUrl($route, $params, $ampersand);
    if ($this->getFrontendMode()) {
      $baseUrl = $this->getBaseUrl();
      return mb_substr($url, mb_strlen($baseUrl));
    }
    return $url;
  }
}