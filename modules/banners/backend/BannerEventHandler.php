<?php

class BannerEventHandler extends BackendEventHandler {

  public function onParameterAvailable(ParameterAvailableEvent $event) {
    parent::onParameterAvailable($event);
    if ($event->status == ViewController::ENTITY_STATUS_NOT_VISIBLE) return;

    $param = $event->objectParameter;
    $name = $param->getFieldName();

    if (in_array($name, array('unique_name') )) {
      $event->status = ViewController::ENTITY_STATUS_NOT_VISIBLE;
    }

    /*if ($name == "file") {
      $idGroup = $urlPage->GET(DA_URL_GROUP_INSTANCE);
      $inst = new BannerPlace();
      if ($idGroup != null && $inst->load($idGroup)) {
        $idObject = $inst->getParam("id_object");
        $idInstance = $inst->getParam("id_instance");
        if ($idObject == DA_OBJECT_MODULE) {
          // По idGroup выводим заголовок по размерам баннеров. $idGroup - как правило фиксированы
          if ($idGroup == 1) {
            $param->caption .= " (ширина 339 px)";
          }
        }
      }
    }*/

    // Если экз. новый, то выходим
    $instance = $event->model;
    if (is_null($instance->getIdInstance()) && $name == "statBanner") {
      $event->status = ViewController::ENTITY_STATUS_NOT_VISIBLE;
    }
  }


}
