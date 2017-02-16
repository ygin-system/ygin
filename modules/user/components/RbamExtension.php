<?php

class RbamExtension extends CComponent implements IBackendExtension {
  
  const ROUTE = 'user/rbam';
  
  public function __construct($userModule) {
    $userModule->modules = array('ygin.rbam' => array(
        'rbacManagerRole' => DaWebUser::ROLE_DEV,
        'authItemsManagerRole' => DaWebUser::ROLE_DEV,
        'authAssignmentsManagerRole' => DaWebUser::ROLE_DEV,
        //'authenticatedRole' => DaWebUser::ROLE_DEV,
        'authenticatedRole' => 'guest',
        'guestRole' => 'guest',
        
        'userIdAttribute' => 'id_user',
        'userNameAttribute' => 'full_name',
        
        'pageSize' => 50,
        'relationshipsPageSize' => 20,
        
        'applicationLayout' => 'user.views.layouts.rbam',
        
    ));
    $userModule->setUrlRules(array('rbam/*' => self::ROUTE));
  }
  
  public function registerEvent($category, $obj) {
    if ($category == BackendModule::CATEGORY_BACKEND_WINDOW) {
      $obj->attachEventHandler(BackendModule::EVENT_ON_BEFORE_MAIN_MENU, array($this, 'onBeforeMainMenu'));
    }
  }
  public function onBeforeMainMenu($event) {
    $sender = $event->sender;
    
    foreach($sender->items AS &$item) {
      if ($item['id_object'] == 2 && Yii::app()->user->checkAccess(DaWebUser::ROLE_DEV)) {
        $items = $item['items'];
        $active = (Yii::app()->controller instanceof RbamController);
        array_unshift($items, array(
            'active' => $active,
            'label' => 'Управление ролями (RBAM)',
            'url' => Yii::app()->createUrl(self::ROUTE),
        ));
        $item['items'] = $items;
        break;
      }
    }
    
  }
  
}