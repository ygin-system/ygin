<?php

class SystemModuleEventHandler extends BackendEventHandler {

  public function onParameterAvailable(ParameterAvailableEvent $event) {
    parent::onParameterAvailable($event);
    if ($event->status == ViewController::ENTITY_STATUS_NOT_VISIBLE) return;

    $param = $event->objectParameter;
    $name = $param->getFieldName();

    $pkey = HU::get(ObjectUrlRule::PARAM_OBJECT_PARENT);
    if ($pkey == null) {
      // Для системных модулей
      if ( in_array( $name, array('properties', 'installer' )) ) {
        $event->status = ViewController::ENTITY_STATUS_NOT_VISIBLE;
        return;
      }
      if ($name == 'id_object') { // TODO временно не поддерживается
        //$param->sql = "parent_object IS NULL OR object_type <> ".DA_OBJECT_TYPE_HEIR;
      }
    } else {
      // Для функциональностей
      if ( in_array( $name, array('id_object', 'id_module_handler' )) ) {
        $event->status = ViewController::ENTITY_STATUS_NOT_VISIBLE;
        return;
      }
    }
    // Для всех
    if ($name == 'php_script_type' && !Yii::app()->user->checkAccess(DaWebUser::ROLE_DEV)) {
      $event->status = ViewController::ENTITY_STATUS_NOT_VISIBLE;
    }
  }

  public function onProcessPermissionWhere(PermissionWhereEvent $event) {
    //Формирование условия отбора
    $pkey = HU::get(ObjectUrlRule::PARAM_OBJECT_PARENT);
    $where = $event->where;
    if ($pkey == "") {
      //$where .= "id_object IS NULL OR id_object IN(SELECT id_object FROM da_object WHERE object_type<>".DA_OBJECT_TYPE_HEIR.")";
      $where = HText::addCondition($where, "id_module_parent IS NULL");
    } else {
      //$where .= "id_object IN(SELECT id_object FROM da_object WHERE object_type=".DA_OBJECT_TYPE_HEIR." AND table_name=$pkey)";
      $where = HText::addCondition($where, "id_module_parent=".$pkey);
    }
    $event->where = $where;
  }

}
