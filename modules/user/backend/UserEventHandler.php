<?php

class UserEventHandler extends BackendEventHandler {

  public function onParameterAvailable(ParameterAvailableEvent $event) {
    parent::onParameterAvailable($event);
    if ($event->status == ViewController::ENTITY_STATUS_NOT_VISIBLE) return;

    $param = $event->objectParameter;
    $name = $param->getFieldName();

    if (!Yii::app()->user->checkAccess(DaWebUser::ROLE_DEV)) {
      if (in_array($name, array('rid', 'create_date', 'count_post', 'group'))) {
        $event->status = ViewController::ENTITY_STATUS_NOT_VISIBLE;
        return;
      }
    }
    if ($name == "create_date") {
      $instance = $event->model;
      if ($instance->getIdInstance() == null) {
        $event->status = ViewController::ENTITY_STATUS_NOT_VISIBLE;
      } else {
        $event->status = ViewController::ENTITY_STATUS_READ_ONLY;
      }
    }
  }

}
