<?php

class BannerPlaceEventHandler extends BackendEventHandler {

  const URL_PARAM_OBJECT = "bObj";
  const URL_PARAM_INSTANCE = "bInst";

  public function onParameterAvailable(ParameterAvailableEvent $event) {
    parent::onParameterAvailable($event);
    if ($event->status == ViewController::ENTITY_STATUS_NOT_VISIBLE) return;

    $param = $event->objectParameter;
    $name = $param->getFieldName();

    if (in_array($name, array('id_object', 'id_instance')) ) {
      $event->status = ViewController::ENTITY_STATUS_NOT_VISIBLE;
    }

    $idObject = intval(HU::get(self::URL_PARAM_OBJECT));
    $idInstance = intval(HU::get(self::URL_PARAM_INSTANCE));
    $pk = intval(HU::get(ObjectUrlRule::PARAM_OBJECT_PARENT));

    //Если есть группировка по объекту или у места есть родитель, скрываем свойство выбора
    if ($name == 'banner_place' && ($idObject && $idInstance || $pk)) {
      $event->status = ViewController::ENTITY_STATUS_NOT_VISIBLE;
    }
  }
  public function onProcessPermissionWhere(PermissionWhereEvent $event) {
    $idObject = intval(HU::get(self::URL_PARAM_OBJECT));
    $idInstance = intval(HU::get(self::URL_PARAM_INSTANCE));
    $where = $event->where;
    if ($idObject && $idInstance) $where = HText::addCondition($where, 'id_object = '.$idObject.' AND id_instance = '.$idInstance);
    $event->where = $where;
  }

}
