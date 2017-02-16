<?php

class DefaultController extends Controller
{
	/**
	 * Проверяет показывался ли баннер в данной сессии
	 * @param Banner $banner
	 * @param int $bannersCount
	 */
  private function bannerWasShown(Banner $banner, $bannersCount) {
    $cookieName = 'bp_'.$banner->id_banner_place;
    $cookieCol = Yii::app()->request->cookies;
    
    $cookie = $cookieCol[$cookieName];
    $value = $banner->id_banner;
    
    if ($cookie !== null) {
      $ids = explode('_', $cookie->value);
      //если были показаны не все баннеры, то смотрим есть ли в куке ид показываемого баннера
      if (count($ids) < $bannersCount) {
        if (in_array($banner->id_banner, $ids)) {
          return true;
        }
        $value .= '_'.$banner->id_banner;
      } 
    } 
    
    $cookie = new CHttpCookie($cookieName, $value);
    $cookie->expire = time() + 3600;
    
    $cookieCol->add($cookieName, $cookie);
    
    return false;
  }

  public function actionClick($unicName) {
    $idObject = Banner::ID_OBJECT;

    /**
     * @var Banner $banner
     */
    $banner = Banner::model()->byUnicName($unicName)->find();
    if ($banner != null) {
      // Статистика за день
      StatView :: newView($idObject, $banner->id_banner, BannerPlace::CLICK_DAY, 'd.m.Y', false);
      // Статистика за месяц
      StatView :: newView($idObject, $banner->id_banner, BannerPlace::CLICK_MONTH, 'm.Y', false);
      // Статистика всего
      StatView :: newView($idObject, $banner->id_banner, BannerPlace::CLICK_ALL, "", false);

      //Вынимаем ссылку
      $link = $banner->link;
      if (mb_strpos($link, "http://") === false && mb_substr($link, 0, 1) != "/") {
        $link = "http://".$link;
      }
      $this->redirect($link); // TODO: сделать пуни-код
    }
  }
  public function actionShow($unicName) {
    $idObject = Banner::ID_OBJECT;

    /**
     * @var Banner $banner
     */
    $banner = Banner::model()->with('bannerFile')->byUnicName($unicName)->find();
    if ($banner != null) {
      $img = $banner->bannerFile->getUrlPath();
      header("Location:".$img);

      if (Yii::app()->getModule('banners')->viewStatisticAvailable) {
        $fileName = Yii::app()->getRuntimePath().'/banner_stat.dat';
        $exists = true;
        if (!file_exists($fileName)) {
          $exists = false;
        }
        if ($fp=fopen($fileName, "a")) {
          $str = time().", ".$banner->id_banner."\r\n";
          fwrite($fp, $str);
          fclose($fp);
        }
        if (!$exists) {
          chmod($fileName, 0777);
        }
      }
    }
  }
  
  public function actionIndex()
	{
	  $bannerPlacesInfo = Yii::app()->request->getQuery('bp', array());
	  
	  if ($bannerPlacesInfo === array()) {
	    echo CJSON::encode(array());
	    Yii::app()->end();
	    //throw new CHttpException('400', 'Invalid request. Please do not repeat this request again.');
	  }
	  
	  
	  $filteredBannerPlacesInfo = array();
	  $ids = array();
	  $bannersWidgetsPath = Yii::app()->getModule('banners')->bannersWidgetsPath;
	  $widgetsPath = Yii::getPathOfAlias($bannersWidgetsPath).DIRECTORY_SEPARATOR;
    
	  $countBannerPlacesInfo = count($bannerPlacesInfo);
	  for($i = 0; $i < $countBannerPlacesInfo; $i++) {
	    
	    if (!isset($bannerPlacesInfo[$i]['id'], $bannerPlacesInfo[$i]['cls'])) {
	      continue;
	    }
	    
	    //получаем ИД баннерного места и класс виджета, который отвечает за его отрисовку
	    //если файл класса не найден, то пропускаем это баннерное место 
	    $curBannerPlaceId = $bannerPlacesInfo[$i]['id'];
	    $curBannerPlaceWidgetClass = $bannerPlacesInfo[$i]['cls'];
	    
	    if (!file_exists($widgetsPath.$curBannerPlaceWidgetClass.'.php')) {
	      Yii::log('Файл "'.$widgetsPath.$curBannerPlaceWidgetClass.'.php'.'" не найден.', CLogger::LEVEL_WARNING, 'application.modules.banners');
	      continue;
	    }
	    
	    //если файл класса найден, то кладем его в массив
	    $filteredBannerPlacesInfo[] = array(
	      'id' => $curBannerPlaceId, 
	      'widget' => $bannersWidgetsPath.'.'.$curBannerPlaceWidgetClass,
	    );
	    
	    $ids[] = $curBannerPlaceId;
	  }
	  
	  //сюда будем собирать код для отрисовки баннерных мест 
	  $placesReplaceCode = array();
	  
	  if (!empty($ids)) {
	    
	    $bannerPlaces = BannerPlace::model()->findAllByPk($ids, array('index' => 'id_banner_place'));
	    $countFiltered = count($filteredBannerPlacesInfo);

	    for ($i = 0; $i < $countFiltered; $i++) {
	      $curBannerPlaceId = $filteredBannerPlacesInfo[$i]['id'];
	      $curBannerPlaceWidget = $filteredBannerPlacesInfo[$i]['widget'];
	      
	      if (!isset($bannerPlaces[$curBannerPlaceId])) {
	        continue;
	      }
	      //модель текущего обрабатываемого баннерного места
	      $bannerPlace = $bannerPlaces[$curBannerPlaceId];
	      
	      //получаем все баннеры для данного баннерного места
	      $banners = Banner::model()->with('bannerFile')->findAll(array(
	        'condition' => 't.id_banner_place = :idPlace',
	        'order' => 'sequence ASC',
	        'params' => array(':idPlace' => $curBannerPlaceId),
	      ));
	      
	      //если баннеров нет, то пропускаем это баннерное место
	      $countBanners = count($banners);
	      if ($countBanners == 0) {
	        continue;
	      }
	      
	      $bannersToShow = array();
	      $indexBannerToShow = -1;
	      
	      if ($bannerPlace->showing == BannerPlace::ST_BY_ORDER || $bannerPlace->showing == BannerPlace::ST_RANDOM) {
	        while (true) {
	          //Если баннеры выводятся в определенном порядке
	          if ($bannerPlace->showing == BannerPlace::ST_BY_ORDER) {
	            $indexBannerToShow++;
	            //Если баннеры отображаются рандомно
	          } else {
	            $indexBannerToShow = rand(0, $countBanners - 1);
	          }
	           
	          $curBanner = $banners[$indexBannerToShow];
	          if (!$this->bannerWasShown($curBanner, $countBanners)) {
	            $bannersToShow = array($curBanner);
	            break;
	          }
	        }
	        //вывод всех баннеров
	      } else {
	        $bannersToShow = $banners;
	        // TODO Добавить ограничение на количество выводимых баннеров в данном месте 
	        /*
	        for ($k = 0; $k < $countBanners; $k++) {
	          $curBanner = $banners[$k];
	          $bannersToShow[] = $curBanner;
	        }
	        */
	      }
	      
	      if (!empty($bannersToShow)) {
	        $idCont = Yii::app()->getModule('banners')->getBannerReplaceContainerId($curBannerPlaceId);
	        
	        //получаем html-код для баннерных мест и html-код баннеров
	        $bannersCode = array();
	        
	        ob_start();
	        $widget = $this->widget($curBannerPlaceWidget, array(
	          'banners' => $bannersToShow,
	        ));
	        $code = ob_get_clean();
	        
	        //сюда заносим html-код для замены по интервалу таймера 
	        $bannersCode = $widget->getBannerReplacementCode();
	        $placesReplaceCode[] = array('id' => $idCont, 'code' => $code, 'banners' => $bannersCode);
	      }
	      
	    }
	  }
	  
	  echo CJSON::encode($placesReplaceCode);
	  
	}
}