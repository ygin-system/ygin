<?php

class CommentEventHandler extends BackendEventHandler {

  const URL_PARAM_OBJECT = 'cObj';
  const URL_PARAM_INSTANCE = 'cInst';

  public function onParameterAvailable(ParameterAvailableEvent $event) {
    parent::onParameterAvailable($event);
    if ($event->status == ViewController::ENTITY_STATUS_NOT_VISIBLE) return;

    $param = $event->objectParameter;
    $name = $param->getFieldName();

    if (in_array($name, array('id_object', 'id_instance')) ) {
      $event->status = ViewController::ENTITY_STATUS_NOT_VISIBLE;
      return;
    }

    if ($name == 'ip') {
      $event->status = ViewController::ENTITY_STATUS_READ_ONLY;
      return;
    }

    /**
     * @var $comment CommentYii
     */
    $comment = $event->model;

    //Показывать автора-пользователя Если id_user не null
    if ($name == 'comment_name' && $comment->id_user != null) {
      $event->status = ViewController::ENTITY_STATUS_NOT_VISIBLE;
      return;
    }

    //Поле "Пользователь" не заполнено user-ом или оно вообще не показывалось
    if ($name == 'id_user' && $comment->id_user == null) {
      $event->status = ViewController::ENTITY_STATUS_NOT_VISIBLE;
      return;
    }
  }
  public function onProcessPermissionWhere(PermissionWhereEvent $event) {
    if ($idObject = intval(HU::get(self::URL_PARAM_OBJECT))) {
      $event->criteria->addCondition('id_object = :id_object_comment');
      $event->criteria->params[':id_object_comment'] = $idObject;
    }
    if ($idInstance = intval(HU::get(self::URL_PARAM_INSTANCE))) {
      $event->criteria->addCondition('id_instance = :id_instance_comment');
      $event->criteria->params[':id_instance_comment'] = $idInstance;
    }
  }
  public function onParameterAvailableToSearch(ParameterAvailableToSearchEvent $event) {
    $param = $event->objectParameter;
    if ($param->getFieldName() != "comment_text") {
      $event->visible = false;
    }
  }

}
