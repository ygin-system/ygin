<?php

class PhotogalleryPhotoEventHandler extends BackendEventHandler {

  public function onParameterAvailable(ParameterAvailableEvent $event) {
    parent::onParameterAvailable($event);
    if ($event->status == ViewController::ENTITY_STATUS_NOT_VISIBLE) return;

    $param = $event->objectParameter;
    $name = $param->getFieldName();

    if (in_array($name, array('id_photogallery_object', 'id_photogallery_instance')) ) {
      $event->status = ViewController::ENTITY_STATUS_NOT_VISIBLE;
    }
  }
  public function onProcessPermissionWhere(PermissionWhereEvent $event) {
    $where = $event->where;
    if ($idObject = intval(HU::get(PhotogalleryPhoto::URL_PARAM_OBJECT))) $where = HText::addCondition($where, "id_photogallery_object = ".$idObject);
    if ($idInstance = intval(HU::get(PhotogalleryPhoto::URL_PARAM_INSTANCE))) $where = HText::addCondition($where, "id_photogallery_instance = ".$idInstance);
    $event->where = $where;
  }
  public function onBeforeGrid(BeforeGridEvent $event) {
    if (isset(Yii::app()->controller->buttons)) {
      if (Yii::app()->authManager->canCreateInstance($this->idObject, Yii::app()->user->id)) {
        Yii::app()->controller->buttons = CMap::mergeArray(
          Yii::app()->controller->buttons, array(array(
            'caption' => '<i class="glyphicon glyphicon-list icon-white"></i> Пакетная загрузка',
            'url' => Yii::app()->createUrl('photogallery/backendPhotogallery/index', array(
              'objectId' => HU::get(PhotogalleryPhoto::URL_PARAM_OBJECT),
              'instanceId' => HU::get(PhotogalleryPhoto::URL_PARAM_INSTANCE),  
            )),
            'class' => 'btn-success',
          )
        ));
      }
    }
  }

}
