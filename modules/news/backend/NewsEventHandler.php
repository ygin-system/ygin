<?php
class NewsEventHandler extends BackendEventHandler {
  public function onParameterAvailable(ParameterAvailableEvent $event) {
    parent::onParameterAvailable($event);
    $module = Yii::app()->getModule('news');
    $param = $event->objectParameter;
    $name = $param->getFieldName();
    if (!$module->showCategories && $name == 'id_news_category') {
      $event->status = ViewController::ENTITY_STATUS_NOT_VISIBLE;
    }
  }
}