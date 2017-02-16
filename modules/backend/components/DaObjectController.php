<?php
abstract class DaObjectController extends DaBackendController {

  protected $idObject = null; // TODO убрать
  private $addCaption = null;

  protected function beforeAction($action) {
    if (parent::beforeAction($action)) {
      $object = Yii::app()->backend->object;
      if ($object == null) {
        $object = DaObject::getById($this->idObject, false);
        Yii::app()->backend->object = $object;
      }
      if (!Yii::app()->authManager->checkObject(DaDbAuthManager::OPERATION_LIST, Yii::app()->user->id, $object->id_object)) {
        // нет прав
        throw new CHttpException(403);
      }
      $objectView = Yii::app()->backend->objectView;
      if ($objectView != null) {
        $object->registerYiiEventHandler($this);
      }
      $title = Yii::app()->backend->objectView == null ? $object->name : $objectView->name;
      $this->setPageTitle($title);
      $this->caption = $title;
    }
    return true;
  }

  public function hasEvent($name) {
    return true;
  }
  
  public function setCaption($caption) {
    if ($this->addCaption === null) {
      $this->addCaption = $this->widget('ObjectSettingWidget', array(), true);
    }
    parent::setCaption($this->addCaption.str_replace($this->addCaption, '', $caption));  // придумать более красивый способ
  }
}