<?php

class DefaultController extends Controller {
   
  public function actionIndex()
  {
    $this->layout = 'main';
    
    $model = new OverrideData();
    $model->theme = Yii::app()->theme->name;
    $model->overrideDataItemTree = $this->getOverrideData();
    
    if (Yii::app()->request->isPostRequest) {
      if (isset($_POST['OverrideData'])) {
        $model->attributes = $_POST['OverrideData'];
        if ($model->validate()) {
          $this->overrideFiles(
            $this->getItemsForOverride($model->data, $model->overrideDataItemTree),
            Yii::app()->theme->getViewPath(),
            $model->rewriteType
          );
          Yii::app()->user->setFlash('override-success', 'Файлы созданы');
          $this->refresh();
        } else {
          Yii::app()->user->setFlash('override-error', CHtml::errorSummary($model));
        }
      }
    }
  
    $this->render('index', array('model' => $model));
  }
  
  public function getExcludeModules() {
    return array(
      'gii',
      'ygin',
      'override',
      'mail',
    );
  }
  
  public function getNames() {
    return array(
      'modules' => 'модули',
      'views' => 'представления',
      'widgets' => 'виджеты',
      'assets' => 'ресурсы',
      'menu' => 'Меню',
      'user' => 'Пользователи',
      'mail' => 'Почта',
      'news' => 'Новости',
      'photogallery' => 'Фотогалерея',
      'shop' => 'Интернет-магазин',
      'vote' => 'Голосование',
      'faq' => 'ЧАВО',
      'feedback' => 'Обратная связь',
      'quiz' => 'Викторина',
      'search' => 'Поиск',
      'review' => 'Отзывы',
      'LoginWidget' => 'Виджет авторизации',
      'NewsWidget' => 'Виджет последних новостей',
      'PhotogalleryWidget' => 'Виджет галереи',
    );
  }
  
  
  public function getItemsForOverride($overrideFilesNames, $overrideDataItems) {
    $overrideItems = array();
    foreach($overrideDataItems as $item) {
      $overrideItems = array_merge($overrideItems, $item->getItemsForOverride());
    }
    $result = array();
    foreach($overrideItems as $item) {
      if (isset($overrideFilesNames[$item->getFullName()])) {
        $result[] = $item;
      }
    }
    return $result;
  }
  
  public function overrideFiles($itemsForOverride, $destinationPath, $rewriteType) {
    
    foreach($itemsForOverride as $item) {
      $overridingDir = $item->getOverridingDir();
      $destPath = $destinationPath.'/'.$overridingDir;
      $fullFilePath = $destPath.'/'.basename($item->path);
      $dirs = explode('/', $overridingDir);
      $destPath = $destinationPath;
     
      foreach($dirs as $dir) {
        $destPath .= '/'.$dir;
        if (!is_dir($destPath)) {
          mkdir($destPath);
          chmod($destPath, 0777);
        }
      }
      
      $copy = true;
      if (file_exists($fullFilePath) && $rewriteType == OverrideData::RW_TYPE_SKIP) {
        $copy = false;
      }
      if ($copy) {
        copy($item->path, $fullFilePath);
        chmod($fullFilePath, 0777);
      }
    }
    
  }

  public function getFiles($path) {
    $files = (file_exists($path) ? HFile::findFiles($path) : array());
    $result = array();
    foreach($files as $key => $file) {
      $item = new OverrideDataItem();
      $item->name = mb_substr($file, mb_strlen($path));
      $item->path = $file;
      $item->mayBeEmpty = true;
      $result[] = $item;
    }
    return $result;
  }
  
  private function getWidgets($path) {
    $result = array();
    $path = HFile::addSlashPath($path);
    if ($dir = @opendir($path)) {
      while (($file = readdir($dir)) !== false) {
        if (($file == ".") || ($file == "..")) continue;
        if (is_file($path.$file) && HFile::getExtension($file) == 'php') {
          $fileContent = file_get_contents($path.$file);
          $widgetClass = mb_substr($file, 0, mb_strlen($file) - 4);
          if (preg_match('/extends\s+\w+(Widget|LinkPager)/su', $fileContent)) {
            $item = new OverrideDataItem();
            $item->name = $widgetClass;
            $item->path = $path.$file;
            $result[] = $item;
          }
        }
      }
      closedir($dir);
    }
    return $result;
  }
  
  public function getWidgetOverrideData($path) {
    $result = array();
    $path = HFile::addSlashPath($path);
    $widgets = $this->getWidgets($path);
    
    if (!($dir = @opendir($path))) return array();

    $assets = array();
    $views = array();
    while (($file = readdir($dir)) !== false) {
      if (($file == ".") || ($file == "..")) continue;
      if (is_dir($path.$file)) {
        if ($file == 'assets') {
          $assets = $this->getFiles($path.$file);
        } elseif ($file == 'views') {
          $views = $this->getFiles($path.$file);
        }
      }
    }
    
    //Если виджет один в папке то собираем его ресурсы по упрощенной схеме
    if (count($widgets) == 1) {
      $result[] = $widgets[0];
      
      $item = new OverrideDataItem();
      $item->name = 'assets';
      $item->path = $path.'assets';
      $item->items = $assets;
      $widgets[0]->addItem($item);
      
      $item = new OverrideDataItem();
      $item->name = 'views';
      $item->path = $path.'views';
      $item->items = $views;
      $widgets[0]->addItem($item);
    } else { //иначе пытаемся определить принадлежность ресурсов
      
      foreach($widgets as $wKey => $widgetItem) {
        $wContent = file_get_contents($widgetItem->path);
        foreach($views as $vKey => $viewItem) {
          $viewName = basename($viewItem->path);
          $viewName = mb_substr($viewName, 0, mb_strlen($viewName) - 4);
          //проверяем принадлежность представления виджету
          if (preg_match('~render\((\'|")/?'.$viewName.'(\'|")~su', $wContent)) {
            $widgetViewsItem = null;
            if (!($widgetViewsItem = $widgetItem->getByName('views'))) {
              $widgetViewsItem = new OverrideDataItem();
              $widgetViewsItem->name = 'views';
              $widgetViewsItem->path = $path.'views';
              $widgetItem->addItem($widgetViewsItem);
            }
            $widgetViewsItem->addItem($viewItem);
          }
        }
      }
      
      foreach($assets as $aKey => $assetsItem) {
        $assetsName = basename($assetsItem->path);
        
        $pattern = '';
        if (HFile::getExtension($assetsName, true) == 'css') {
          $pattern = '~registerCssFile\(("|\')'.$assetsName.'("|\')~su';
        } elseif (HFile::getExtension($assetsName, true) == 'js') {
          $pattern = '~registerJsFile\(("|\')'.$assetsName.'("|\')~su';
        } else {
          $pattern = '~'.basename($assetsName).'~su';
        }
      
        foreach($widgets as $wKey => $widgetItem) {
          $wContent = file_get_contents($widgetItem->path);
          //Возможно ресурс публикуется из виджета
          $addAssets = (bool)preg_match($pattern, $wContent);
          if ($widgetItem->getByName('views') != null && !$addAssets) {
            //проверяем принадлежность ресурса представлению
            foreach($widgetItem->getByName('views') as $vKey => $viewItem) {
              $vContent = file_get_contents($viewItem->path);
              if (preg_match($pattern, $vContent)) {
                $addAssets = true;
                break;
              }
            }
          }
          if ($addAssets) {
            $widgetAssetsItem = null;
            if (!($widgetAssetsItem = $widgetItem->getByName('assets'))) {
              $widgetAssetsItem  = new OverrideDataItem();
              $widgetAssetsItem->name = 'assets';
              $widgetAssetsItem->path = $path.'assets';
              $widgetItem->addItem($widgetAssetsItem);
            }
            $widgetAssetsItem->addItem(clone $assetsItem); //clone так, как ассет может принадлежать разным виджетам
          }
        }
      }//end foreach
      
      $result = $widgets;
      
    }//end else
    
    //Собираем виджеты по вложенным папкам
    rewinddir($dir);
    while (($file = readdir($dir)) !== false) {
      if (($file == ".") || ($file == "..")) continue;
      if (is_dir($path.$file)) {
        if ($file != 'assets' && $file != 'views') {
          $result = array_merge($result, $this->getWidgetOverrideData($path.$file));
        }
      }
    }
    
    closedir($dir);
    
    return $result;
  }
  
  public function getModuleOverrideData($module) {
    $result = array();
    $modulePath = $module->getBasePath();
    
    $item = new OverrideDataItem();
    $item->name = 'assets';
    $item->path = $modulePath.'/assets';
    $item->items = $this->getFiles($modulePath.'/assets');
    $result[] = $item;
    
    $item = new OverrideDataItem();
    $item->name = 'views';
    $item->path = $modulePath.'/views';
    $item->items = $this->getFiles($modulePath.'/views');
    $result[] = $item;
    
    $item = new OverrideDataItem();
    $item->name = 'widgets';
    $item->path = $modulePath.'/widgets';
    $item->items = $this->getWidgetOverrideData($modulePath.'/widgets');
    $result[] = $item;
    
       
    return $result;
  }
    
  public function getOverrideData() {
    $result = array();
    $item = new OverrideDataItem();
    $item->name = 'modules';
    $result[] = $item;
    
    foreach (Yii::app()->getModules() as $moduleName => $params) {
      if (in_array($moduleName, $this->getExcludeModules())) continue;
      $module = Yii::app()->getModule($moduleName);
      $item = new OverrideDataItem();
      $item->name = $module->getId();
      $item->path = $module->getBasePath();
      $item->items = $this->getModuleOverrideData($module);
      $result[0]->addItem($item);
      
    }
    $item = new OverrideDataItem();
    $item->name = 'widgets';
    $item->path = Yii::getPathOfAlias('ygin.widgets');
    $item->items = $this->getWidgetOverrideData(Yii::getPathOfAlias('ygin.widgets'));
    
    $result[] = $item;
    
    foreach($result as $key => $item) {
      if ($item->deleteEmpty()) {
        unset($result[$key]);
      }
    }
    
    return $result;
  }
  
  private function renderItem(OverrideDataItem $item, $htmlOptions = array(), $checked = array()) {
    $names = $this->getNames();
    $options = CMap::mergeArray(array(
      'for' => CHtml::getIdByName($item->getFullName()),
    ), $htmlOptions);
    if (isset($options['class'])) {
      $options['class'] = 'checkbox '.$options['class'];
    } else {
      $options['class'] = 'checkbox';
    }
    $label = $item->name;
    echo CHtml::openTag('label', $options);
    echo isset($names[$label]) ? $label.' ('.$names[$label].')': $label;
    echo CHtml::checkBox('OverrideData[data]['.$item->getFullName().']', isset($checked[$item->getFullName()]));
    echo CHtml::closeTag('label');
  }
  
  public function renderRecursive($array, $checked = array()) {
    echo CHtml::openTag('ul', array('class' => 'overrideList'));
    foreach($array as $key => $item) {
      echo CHtml::openTag('li');
      if (count($item->items) > 0) {
        $this->renderItem($item, array('class' => 'parent'), $checked);
        $this->renderRecursive($item->items, $checked);
      } else {
        $this->renderItem($item, array(), $checked);
      }
      echo CHtml::closeTag('li');
    }
    echo CHtml::closeTag('ul');
    
  }
}
