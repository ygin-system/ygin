<?php
  class DaFrontendController extends DaWebController {

    protected $urlAlias = null;
    
    public function processOutput($output) {
      $output = parent::processOutput($output);
      if (true || $this->_encodeEmail) {  // TODO
        $output = HEmailEncode::encodeHtmlSource($output);
      }
      return $output;
    }
    
    protected function beforeAction($action) {
      if (parent::beforeAction($action)) {
        // Пытаемся найти раздел меню по урлу
        if (Yii::app()->menu->setCurrent($this->getRoute(), $this->getActionParams(), $this->urlAlias)) {
        	// заголовок страницы
          $this->caption = Yii::app()->menu->current->caption; 

          // цепочка навигации
          $menu = Yii::app()->menu->current;
          while ($menu != null) {
            $this->breadcrumbs[$menu->caption == null ? $menu->name : $menu->caption] = $menu->getUrl();
            $menu = $menu->getParent();
          }
          $this->breadcrumbs = array_reverse($this->breadcrumbs);
          $menu = Yii::app()->menu->current;
          
          // title
          if ($menu->title_teg != null) $this->setPageTitle($menu->title_teg);
          
          // keyword
          if ($menu->meta_keywords != null) $this->setKeywords($menu->meta_keywords);
          
          // description
          if ($menu->meta_description != null) $this->setDescription($menu->meta_description);
          	else $this->setDescription($menu->caption);
          	
        }
        return true;
      }
      return false;
    }
    
    public function getKeywords($generateIfEmpty=true, $data=null) {
    	$keywords = parent::getKeywords();
    	if (!$generateIfEmpty) return $keywords;
    	
    	if ($keywords == null && $data != null) {
    		$preg      = '/<h[123456].*?>(.*?)<\/h[123456]>/i';
      	$content   = str_replace("\n", "", str_replace("\r", "", $data ));
      	$pregCount = preg_match_all($preg, $content, $headers);
      	$keywords = '';
        for ($i = 0; $i < $pregCount; $i++) {
      		if ($keywords != '') $keywords .= ', ';
          $item = trim(strip_tags($headers[0][$i]));
          if ($item == '') continue;
        	$keywords .= $item;
        	if (mb_strlen($keywords) > 200) break;
      	}
    	}
      if ($keywords == null && isset(Yii::app()->domain)) {
	      $keywords = Yii::app()->domain->model->keywords;
      }
      return str_replace('@', '[at]', $keywords);
    }
    
    protected function afterRender($view, &$output) {
  		Yii::app()->clientScript->registerMetaTag($this->getKeywords(true, $output), 'keywords');
  		Yii::app()->clientScript->registerMetaTag($this->getDescription(), 'description');
  		Yii::app()->clientScript->registerMetaTag(Yii::app()->domain->model->description, 'application-name');
  		Yii::app()->clientScript->registerMetaTag(Yii::app()->domain->model->description, 'msapplication-tooltip');
  		Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo, 'msapplication-starturl');
  		
  		Yii::app()->clientScript->registerLinkTag('home', null, Yii::app()->request->hostInfo);
  		Yii::app()->clientScript->registerLinkTag('icon', "image/x-icon", '/favicon.ico');
  		Yii::app()->clientScript->registerLinkTag('shortcut icon', "image/x-icon", '/favicon.ico');
  		
  		/* TODO
  		// текущая локализация
  		$t = $locale->getCode();
    	$daPage->addMetaTeg(HtmlPage::METATEG_NAME_CONTENT_LANGUAGE, '<meta http-equiv="content-language" content="'.$t.'" > ');
    	
    	// картинка домена
    	if ($img = $daDomain->getImage()) {
      	$daPage->addLinkTag("image_src", $img->getUrlPath());
    	}
    	*/
		}    

		
    public function actions() {
    	return array(
        'captcha' => array(
          'class' => 'DaCaptchaAction',
          'maxLength' => 5,
          'minLength' => 4,
    	  ),
    	);
    }
    
  }