<?php
class ObjectParameterEventHandler extends BackendEventHandler {
  public function onParameterAvailable(ParameterAvailableEvent $event) {
    if ($event->objectParameter->getIdParameter() == '75') { // ид объекта
      $event->status = ViewController::ENTITY_STATUS_NOT_VISIBLE;
    }
    parent::onParameterAvailable($event);
  }
}