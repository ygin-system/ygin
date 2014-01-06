<?php
Yii::import('zii.widgets.CMenu');
class MainMenuWidget extends CMenu {
 
  public $htmlOptions = array('class' => 'panel-body nav nav-list');
  public $activeCssClass = 'active';
  
  public $idObjectCurrent = null;
  public $idObjectViewCurrent = null;
  
  private function fillItems(array $childs, $level, $availableObjects) {
    $items = array();
    foreach($childs AS $child) {
      /**
       * @var $child DaObject
       */
      $views = $child->views;
      if (in_array($child->id_object, $availableObjects, true)) {
        if (count($views) > 0) {
          foreach ($views AS $view) {
            $active = false;
            if ($this->idObjectViewCurrent == $view->id_object_view) $active = true;

            $add = ($view->icon_class != null) ? '<i class="'.$view->icon_class.($active ? ' icon-white' : '').'"></i> ' : '';
            $items[] = array(
              'active' => $active,
              'label' => $add.$view->name,
              'url' => '/admin/page/'.$child->id_object.'/view/'.$view->id_object_view.'/', // TODO
            );
          }
        } else if ($child->object_type == DaObject::OBJECT_TYPE_CONTROLLER) {
          // если это ручной объект то выводим без представления
          $active = false;
          if ($this->idObjectCurrent == $child->id_object) $active = true;
          //$url = (mb_strpos($child->table_name, '/') === false ? Yii::app()->controller->createUrl($child->table_name) : '/admin/page/'.$child->id_object.'/');
          //$url = Yii::app()->controller->createUrl($child->table_name);
          $url = '/admin/page/'.$child->id_object.'/';
          $items[] = array(
              'active' => $active,
              'label' => $child->name,
              'url' => $url,
          );
        } else if ($child->object_type == DaObject::OBJECT_TYPE_LINK)  {
          // объект-ссылка
          $active = false;
          if ($this->idObjectCurrent == $child->id_object) $active = true;
          $url = $child->table_name;
          $items[] = array(
            'active' => $active,
            'label' => $child->name,
            'url' => $url,
            'linkOptions' => array('target' => '_blank'),
          );
        }
      }
      if ($level < 2 && $child->countChild > 0) { // объект является папкой
        $items = array_merge($items, $this->fillItems($child->child(array('with'=>array('views:selectName', 'countChild'), 'select'=>'child.id_object, child.object_type, child.name, child.table_name')), $level+1, $availableObjects));
      }
    }
    return $items;
  }
  
  public function init() {
    $currentView = Yii::app()->backend->objectView;
    $currentObject = Yii::app()->backend->object;
    if ($this->idObjectCurrent == null && $currentObject != null) $this->idObjectCurrent = $currentObject->id_object;
    if ($this->idObjectViewCurrent == null && $currentView != null) $this->idObjectViewCurrent = $currentView->id_object_view;

    // Получаем все доступные для просмотра объекты
    $availableObjects = Yii::app()->authManager->checkObject(DaDbAuthManager::OPERATION_LIST, Yii::app()->user->id);
    if (count($availableObjects) == 0) return;
    // Загружаем объекты первого уровня
    $cr = new CDbCriteria();
    $cr->condition = 't.parent_object IS NULL';
    $cr->select = 't.name, t.id_object, t.table_name';
    $objects = DaObject::model()->orderBySeq()->with(array(
            'child' => array('with'=>'countChild', 'select'=>'child.id_object, child.name, child.object_type, child.table_name'),
            'child.views' => array('scopes'=>'selectName'),
            ))->findAll($cr);
    
    foreach($objects AS $object) {
      if (count($object->child) == 0) continue;
      
      $this->items[] = array(
        'active' => false,
        'label' => $object->name,
        'url' => null,
        'id_object' => $object->id_object,
        'items' => $this->fillItems($object->child, 1, $availableObjects)
      );
    }
    //print_r($this->items);exit;
    Yii::app()->clientScript->registerScript('menu.run', '
      $(".b-menu-side-main .panel-heading.active").parents(".panel").removeClass("panel-default").addClass("panel-primary");
      if ($(".b-menu-side-main .in").length == 0) $(".b-menu-side-main .panel-heading:eq(0)").click();
    ', CClientScript::POS_LOAD);
  }
  
  public function run() {
    $items = $this->items;
    foreach($items AS $item) {
      $this->items = $item['items'];
      if (count($this->items) == 0) continue;
      echo '<div class="panel panel-default">
              <a class="panel-heading" href="#smm-'.$item['id_object'].'" data-toggle="collapse">'.$item['label'].'</a>
              <div id="smm-'.$item['id_object'].'" class="collapse panel-collapse">';
      parent::run();
      echo '
              </div>
            </div>
';
    }
  }
  
}
