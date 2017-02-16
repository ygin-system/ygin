<?php
/**
 * Действие для создания Rss-ленты
 * @author timofeev_ro
 */
Yii::import('ygin.ext.efeed.*');

class RssAction extends CAction {
  /**
   * Функция, возвращающая массив элементов EFeedItemAbstract. 
   * Должна быть корректной функцией обратного вызова. 
   * @var $mixed
   */
  public $onRssItems;
  /**
   * Тип Rss-канала
   * Доступные типы: EFeed::RSS1, EFeed::RSS2, EFeed::ATOM,
   * @var string
   */
  public $type = EFeed::RSS2;
  
  private $_feedSettings = array();
  
  public function run() {
    $this->controller->layout = false;
    $feedSettings = CMap::mergeArray($this->getDefaultFeedSettings(), $this->getFeedSettings());
    
    $feedItems = $this->getRssItems();
    
    $feed = new EFeed($this->type);
    
    $channelTags = HArray::val($feedSettings, 'channelTags', array());
    unset($feedSettings['channelTags']);
    
    //Настраиваем канал
    foreach ($feedSettings as $settingName => $settingValue) {
      $feed->$settingName = $settingValue;
    }
    $feed->addChannelTagsArray($channelTags);
    
    //Заносим элементы канала
    $c = count($feedItems);
    for ($i = 0; $i < $c; $i++) {
      $feed->addItem($feedItems[$i]);
    }

    if ($c == 0) {
      echo 'No feed items';
      return;
    }
    
    //рендерим канал
    $feed->generateFeed();
  }
  /**
   * Возвращает массив элементов EFeedItemAbstract для Rss-ленты
   * @return array EFeedItemAbstract
   */
  protected function getRssItems() {
    return call_user_func($this->onRssItems);
  }
  
  public function getFeedSettings() {
    return $this->_feedSettings;
  }
  
  protected function getDefaultFeedSettings() {
    switch ($this->type) {
      case EFeed::RSS1: 
        return array();
      case EFeed::RSS2:
        return array(
          'title' => 'Rss 2.0',
          'description' => 'Rss 2.0 feed',
          'channelTags' => array(
            'language' => 'ru-RU',
            'pubDate' => date(DATE_RSS, time()),
          ),
        );
      case EFeed::ATOM:
        return array();
    }
  }
  
  public function setFeedSettings($settings) {
    $this->_feedSettings = $settings;
  }
  
}