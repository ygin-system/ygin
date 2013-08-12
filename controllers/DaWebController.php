<?php

class DaWebController extends CController {

  private $_caption = '';
  private $_assetsPath = null;
  private $_pageTitle = null;
  private $_plainTitle = null;
  private $_keywords = null;
  private $_description = null;

  public $favicon = null;
  public $addDomainCaptionToTitle = true;
  public $titleSeparator = '<';

  /**
   * @var array the breadcrumbs of the current page. The value of this property will
   * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
   * for more details on how to specify this property.
   */
  public $breadcrumbs = array();
  public $useBreadcrumbs = true;

  public function addBreadcrumb($caption, $link) {
    $this->breadcrumbs[$caption] = $link;
  }
  public function addBreadcrumbs(array $breadcrumbs) {
    $this->breadcrumbs = array_merge($this->breadcrumbs, $breadcrumbs);
  }


  public function setCaption($caption) {
    $this->_caption = $caption;
  }
  public function getCaption() {
    return $this->_caption;
  }
  
  /**
   * Путь к файлам ресурсов (css, js). В конце присутствует DIRECTORY_SEPARATOR
   * @return string
   */
  public function getAssetsPath() {
    if ($this->_assetsPath === null) {
      if ($this->module !== null) {
        $this->_assetsPath = $this->module->getBasePath() . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
      } else {
        $this->_assetsPath = Yii::getPathOfAlias('application.assets') . DIRECTORY_SEPARATOR;
      }
    }
    return $this->_assetsPath;
  }

  private function getThemeAssetsPath($fileName) {
    if (($theme=Yii::app()->getTheme()) !== null) {
      $viewPath = $theme->getViewPath();
      if (($module=$this->getModule()) !== null) {
        $viewPath .= '/'.$module->getId();
      }
      $viewPath .= '/assets/';
      if (is_file($viewPath.$fileName)) {
        return $viewPath;
      }
    }
    return null;
  }

  public function registerCssFile($cssFile, $path = null) {
    if ($path == null) $path = $this->getThemeAssetsPath($cssFile);
    if ($path == null) {
      $path = $this->getAssetsPath();
    } else if (strpos($path, '/') === false) {
      $path = Yii::getPathOfAlias($path) . DIRECTORY_SEPARATOR;
    }
    $cs = Yii::app()->clientScript;
    $cs->registerCssFile(Yii::app()->getAssetManager()->publish($path . $cssFile, true));
  }

  public function registerJsFile($jsFile, $path = null, $inRootAssets=false) {
    if ($path == null) $path = $this->getThemeAssetsPath($jsFile);
    if ($path == null)
      $path = $this->getAssetsPath();
    else if (strpos($path, '/') === false)
      $path = Yii::getPathOfAlias($path) . DIRECTORY_SEPARATOR;
    $cs = Yii::app()->clientScript;
    $url = '';
    if ($inRootAssets) {
      $url = Yii::app()->assetManager->getBaseUrl().'/'.$jsFile;
    } else {
      $url = Yii::app()->getAssetManager()->publish($path . $jsFile, true);
    }
    $cs->registerScriptFile($url);
  }

  public function throw404Error($errorMessage = null) {
    if ($errorMessage === null) {
      $errorMessage = 'The requested page does not exist.';
    }
    throw new CHttpException(404, $errorMessage);
  }

  public function addPageTitle($value) {
    if ($this->_plainTitle != null) {
      $this->_plainTitle .= ' ' . $value;
      return;
    }

    if (empty($this->_pageTitle)) {
      $this->_pageTitle = $this->getBreadcrumbsValues();
    }

    if (is_string($this->_pageTitle)) {
      $this->_pageTitle .= ' ' . $value;
    } elseif (is_array($this->_pageTitle)) {
      array_push($this->_pageTitle, $value);
    }
  }

  protected function getBreadcrumbsValues() {
    $res = array();
    foreach ($this->breadcrumbs as $key => $val) {
      if (is_numeric($key) && is_string($val)) {
        $res[] = $val;
      } elseif (is_string($key)) {
        $res[] = $key;
      }
    }
    return $res;
  }

  public function setPageTitle($value) {
    $this->_plainTitle = $value;
  }

  public function getPageTitle() {
    if ($this->_plainTitle != null)
      return trim(strip_tags($this->_plainTitle));
    $title = '';

    if (empty($this->_pageTitle)) {
      $this->_pageTitle = $this->getBreadcrumbsValues();
    }

    if (is_string($this->_pageTitle)) {
      $title = $this->_pageTitle;
    } elseif (is_array($this->_pageTitle)) {
      $title = implode(' '.$this->titleSeparator.' ', array_reverse($this->_pageTitle));
    }

    if (empty($title)) {
      $title = $this->caption;
    }

    if ($this->addDomainCaptionToTitle && isset(Yii::app()->domain) && !empty($title)) {
      $description = Yii::app()->domain->model->description;
      if (!empty($description)) {
        $title .= ' | '.$description;
      }
    }

    if (empty($title)) {
      $title = parent::getPageTitle();
    }

    return trim(strip_tags($title));
  }

  public function setDescription($value) {
    $this->_description = $value;
  }

  public function getDescription() {
    if (!empty($this->_description)) {
      return $this->_description;
    }
    return $this->getPageTitle();
  }

  public function setKeywords($value) {
    $this->_keywords = $value;
  }

  public function getKeywords() {
    return $this->_keywords;
  }

  public function loadModelOr404($modelClass, $pk, $notFoundMessage = 'Запрашиваемая страница не найдена.') {
    $model = DaActiveRecord::model($modelClass)->findByPk($pk);
    return $this->throw404IfNull($model, $notFoundMessage);
  }
  public function throw404IfNull($model, $notFoundMessage = 'Запрашиваемая страница не найдена.') {
    if ($model === null) {
      throw new CHttpException(404, $notFoundMessage);
    }
    return $model;
  }
}