<?php


class CommentsViewLinkColumn extends BaseColumn {
  public $htmlOptions = array('class'=>'ref');

  private $cache = array();

  protected function renderDataCellContent($row, $data) {

    if (!$data instanceof CommentYii) return;
    $key = $data->id_object.'_'.$data->id_instance;
    $owner = null;
    if (isset($this->cache[$key])) {
      $owner = $this->cache[$key];
    }
    if ($owner || (!$owner && ($owner = $data->getOwnerModel()))) {
      $this->cache[$key] = $owner;
      $method = '';
      if (method_exists($owner, 'getCommentsUrl')) {
        $method = 'getCommentsUrl';
      } elseif (method_exists($owner, 'getUrl')) {
        $method = 'getUrl';
      } elseif (method_exists($owner, 'getViewUrl')) {
        $method = 'getViewUrl';
      }
      if ($method) {
        Yii::app()->urlManager->frontendMode = true;
        $link = Yii::app()->createUrl($owner->$method());
        Yii::app()->urlManager->frontendMode = false;
        echo CHtml::link('<i class=" icon-share"></i> просмотреть на сайте', $link, array('target'=>'_blank'));
      }
    }
  }
}