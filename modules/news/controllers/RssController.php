<?php

class RssController extends Controller {

  public function actions() {
    if (!$this->module->useRss) return array();
    $linkDomain = Yii::app()->domain->getModel()->getDomainName();
    return array(
      'rss' => array(
        'class' => 'RssAction',
        'onRssItems' => array($this, 'getRssItems'),
        'feedSettings' => array(
          'title' => 'Новости',
          'description' => 'Новости сайта '.$linkDomain,
          'link' => 'http://'.$linkDomain,
        ),
      ),
    );
  }

  public function getRssItems() {
    $criteria = new CDbCriteria();
    $criteria->order = 'date DESC';
    $criteria->limit = 20;

    $data = News::model()->findAll($criteria);
    $res = array();
    $linkDomain = 'http://'.Yii::app()->domain->getModel()->getDomainName();
    foreach ($data as $model) {
      /**
       * @var $model News
       */
      $link = $linkDomain.$model->getUrl();
      $feedItem = new EFeedItemRSS2();
      $feedItem->title = $model->title;
      $feedItem->link = $link;
      $feedItem->date = $model->date;
      $feedItem->description = strip_tags(nl2br($model->short)).' <div><a href="'.$link.'">Полный текст</a> »</div>';
      $res[] = $feedItem;
    }
    return $res;
  }

}