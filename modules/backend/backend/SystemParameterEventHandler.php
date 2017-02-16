<?php

class SystemParameterEventHandler extends BackendEventHandler {

  public function onParameterAvailable(ParameterAvailableEvent $event) {
    parent::onParameterAvailable($event);
    if ($event->status == ViewController::ENTITY_STATUS_NOT_VISIBLE) return;

    $param = $event->objectParameter;
    $name = $param->getFieldName();

    if (in_array($name, array('id_group_system_parameter', 'id_parameter_type', 'name')) && !Yii::app()->user->checkAccess(DaWebUser::ROLE_DEV)) {
      $event->status = ViewController::ENTITY_STATUS_NOT_VISIBLE;
    }
    if (in_array($name, array('note')) && !Yii::app()->user->checkAccess(DaWebUser::ROLE_DEV)) {
      $event->status = ViewController::ENTITY_STATUS_READ_ONLY;
    }
  }

  /**
   * Позволяет уточнить where-условие для ограничения доступа пользователю.
   *
   * @param PermissionWhereEvent $event - событие системы
   */
  public function onProcessPermissionWhere(PermissionWhereEvent $event) {
    if (!Yii::app()->user->checkAccess(DaWebUser::ROLE_DEV)) {
      $event->criteria->addCondition('id_group_system_parameter = 2');
    }
  }

}
