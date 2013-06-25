<?php

class ObjectSettingWidget extends DaWidget {
  
  public function run() {
    $view = Yii::app()->backend->objectView;
    $object = Yii::app()->backend->object;
    
    if ($object != null && Yii::app()->authManager->checkObject(DaDbAuthManager::OPERATION_EDIT, Yii::app()->user->id, DaObject::ID_OBJECT) ) {
      $link = Yii::app()->createUrl(BackendModule::ROUTE_INSTANCE_VIEW, array(
          ObjectUrlRule::PARAM_OBJECT => DaObject::ID_OBJECT,
          ObjectUrlRule::PARAM_OBJECT_INSTANCE => $object->id_object,
          ObjectUrlRule::PARAM_OBJECT_VIEW => 2,
          ObjectUrlRule::PARAM_OBJECT_PARENT => $object->parent_object,
        ));
      echo '<a href="'.$link.'" target="_blank" title=\'Настроить объект\' class="btn btn-mini"><i class="icon-wrench"></i></a>';
    }
    if ($view != null && Yii::app()->authManager->checkObject(DaDbAuthManager::OPERATION_LIST, Yii::app()->user->id, DaObjectView::ID_OBJECT)) {
      $link = Yii::app()->createUrl(BackendModule::ROUTE_INSTANCE_LIST, array(
          ObjectUrlRule::PARAM_OBJECT => DaObjectView::ID_OBJECT,
          ObjectUrlRule::PARAM_GROUP_OBJECT => DaObject::ID_OBJECT,
          ObjectUrlRule::PARAM_GROUP_INSTANCE => $object->id_object,
          ObjectUrlRule::PARAM_GROUP_PARAMETER => 401,
        ));
      echo '<a href="'.$link.'" target="_blank" title=\'Представления объекта\' class="btn btn-mini"><i class="icon-eye-open"></i></a>';
    }
    if ( $object != null && $object->object_type == DaObject::OBJECT_TYPE_TABLE) {
      if ( Yii::app()->authManager->checkObject(DaDbAuthManager::OPERATION_EDIT, Yii::app()->user->id, ObjectParameter::ID_OBJECT) ) {
        $link = Yii::app()->createUrl(BackendModule::ROUTE_INSTANCE_VIEW, array(
          ObjectUrlRule::PARAM_OBJECT => ObjectParameter::ID_OBJECT,
          ObjectUrlRule::PARAM_GROUP_OBJECT => DaObject::ID_OBJECT,
          ObjectUrlRule::PARAM_GROUP_INSTANCE => $object->id_object,
          ObjectUrlRule::PARAM_GROUP_PARAMETER => 75,
        ));
        echo '<a href="'.$link.'" target="_blank" title=\'Список свойств объекта\' class="btn btn-mini"><i class="icon-list"></i></a>';
      }
    }
  }
  
}
