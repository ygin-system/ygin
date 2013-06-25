<?php
class DaWidget extends CWidget {
  
  private $_assetsPath = null;
  private $_basePath = null;
  
  /**
   * Получает путь, где лежит описание класса
   * @return string
   */
  public function getBasePath() {
    if ($this->_basePath === null) {
      $class = new ReflectionClass(get_class($this));
      $this->_basePath = dirname($class->getFileName());
    }
    return $this->_basePath;
  }

  private function getThemeAssetsPath($fileName) {
    if (($theme=Yii::app()->getTheme()) !== null) {
      $assetsPath = $theme->getViewPath().'/'.get_class($this).'/assets/';
      if (is_file($assetsPath.$fileName)) {
        return $assetsPath;
      }
    }
    return null;
  }

  /**
   * Путь к файлам ресурсов (css, js). В конце присутствует DIRECTORY_SEPARATOR
   * @return string
   */
  public function getAssetsPath($fileName=null) {
    if ($this->_assetsPath === null) {
      $this->_assetsPath = $this->getBasePath().DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR;
    }
    if ($fileName != null) {
      if (!is_file($this->_assetsPath.$fileName)) {
        $class = new ReflectionClass(get_class($this));
        $pClass = $class->getParentClass();
        while($pClass->getName() != 'DaWidget') {
          $basePath = dirname($pClass->getFileName());
          if (is_file($basePath.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.$fileName)) {
            return $basePath.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR;
          }
          $pClass = $pClass->getParentClass();
        }
      }
    }
    return $this->_assetsPath;
  }
    
  public function registerCssFile($cssFile, $path=null) {
    if ($path == null) $path = $this->getThemeAssetsPath($cssFile);
    if ($path == null) {
      $path = $this->getAssetsPath($cssFile);
    } else if (strpos($path, '/') === false) {
      $path = Yii::getPathOfAlias($path) . DIRECTORY_SEPARATOR;
    }

    $cs = Yii::app()->clientScript;
    $cs->registerCssFile(Yii::app()->getAssetManager()->publish($path.$cssFile, true));
  }
  public function registerJsFile($jsFile, $path=null) {
    if ($path == null) $path = $this->getThemeAssetsPath($jsFile);
    if ($path == null) {
      $path = $this->getAssetsPath($jsFile);
    } else if (strpos($path, '/') === false) {
      $path = Yii::getPathOfAlias($path) . DIRECTORY_SEPARATOR;
    }
    $cs = Yii::app()->clientScript;
    $cs->registerScriptFile(Yii::app()->getAssetManager()->publish($path.$jsFile, true));
  }
}