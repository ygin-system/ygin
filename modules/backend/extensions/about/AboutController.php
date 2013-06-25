<?php

class AboutController extends DaBackendController implements IBackendExtension {

  public function actionIndex() {

    $this->render('backend.extensions.about.view', array(
    ));

  }
  
  // реализация события класса как компонента
  public function registerEvent($category, $obj) {
    if ($category == BackendModule::CATEGORY_BACKEND_WINDOW) {
      $obj->attachEventHandler(BackendModule::EVENT_ON_BEFORE_TOP_MENU, array($this, 'onBeforeTopMenu'));
    }
  }
  public function onBeforeTopMenu($event) {
    $sender = $event->sender;
    
    $sender->items[] = array(
      'label' => 'О системе',
      'url' => Yii::app()->createUrl('about'),
      'active' => false,
    );
  }
}
