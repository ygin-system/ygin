<?php

class NewsModule extends DaWebModuleAbstract {

  const ROUTE_NEWS_CATEGORY = 'news/news/index';

  protected $_urlRules = array(
    'news/category/<idCategory:\d+>' => self::ROUTE_NEWS_CATEGORY,
    'news/<id:\d+>' => 'news/news/view',
    'news/*' => self::ROUTE_NEWS_CATEGORY,
    //'rss/<channel:[\w\W]+>/*' => 'news/news/rss',
  );
  
  private $_itemsCountPerPage = 20;
  private $_listDateFormat = 'd.MM.yyyy';
  public $defaultController = 'news';
  public $useRss = true;

  /**
   * Формат даты одиночной новости
   * @property string
   */
  public $singleNewsDateFormat = 'd MMMM yyyy';

  /**
   * Отображать ли категории новостей над списком новостей
   * @property boolean
   */
  public $showCategories = false;

  public function getVersion() {
    return '0.0.1';
  }

  /**
   * Количество новостей на странице
   * @return number
   */
  public function getItemsCountPerPage() {
    return $this->_itemsCountPerPage;
  }

  public function setItemsCountPerPage($countNewsPerPage) {
    $this->_itemsCountPerPage = $countNewsPerPage;
  }

  public function setListDateFormat($listDateFormat) {
    $this->_listDateFormat = $listDateFormat;
  }

  /**
   * Формат даты в списке (формат не такой как у функции date(), варианты форматов http://www.unicode.org/reports/tr35/#Date_Format_Patterns)
   * @return string
   */
  public function getListDateFormat() {
    return $this->_listDateFormat;
  }

  public function init() {
    $this->setImport(array(
        $this->getId() . '.models.*',
        $this->getId() . '.components.*',
    ));

    if ($this->useRss && Yii::app()->isFrontend) {
      Yii::app()->attachEventHandler('onBeginRequest', array($this, 'registerRss')); // чтоб подключились маршруты
      $this->_urlRules['rss/news/*'] = 'news/rss/rss';
    }
  }

  public function registerRss(CEvent $event) {
    Yii::app()->clientScript->registerLinkTag('alternate', 'application/rss+xml', Yii::app()->createUrl('news/rss/rss'));
  }


}
