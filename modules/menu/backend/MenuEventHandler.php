<?php

class MenuEventHandler extends BackendEventHandler {

  public function onParameterAvailable(ParameterAvailableEvent $event) {
    parent::onParameterAvailable($event);
    return;
    if ($event->status == ViewController::ENTITY_STATUS_NOT_VISIBLE) return;

    $param = $event->objectParameter;
    $name = $param->getFieldName();

    /**
     * @var $instance Menu
     */
    /*$instance = $event->params['model'];
    if ($instance->isNewRecord && $name == 'removable') {
      $instance->setRemovable(true);
    }*/
    return;

    // Определяем тип создаваемого/редактируемого раздела
    /*$static = true;
    if ($instance->getIdInstance() != null) {
      if ($instance->getParam("handler") != null) {
        $static = false;
      }
    } else {
      global $urlPage;
      if ($urlPage->GET(DA_URL_MODULE) != null) {
        $static = false;
      }
    }

    if ($static) {
      if ($name == "handler") {
        return DA_INSTANCE_NOT_VISIBLE;
      }
    } else { // динамический раздел
      $disable = array("content", "listFiles", "go_to_type");
      if (in_array($name, $disable)) {
        return DA_INSTANCE_NOT_VISIBLE;
      }
      //Если новый раздел, то по умолчанию снимаем галку "Удалять раздел"
      if ($instance->isNew() && $name == 'removable') {
        $instance->setRemovable(false);
      }
    }
    return DA_INSTANCE_AVAILABLE;*/
  }



}
