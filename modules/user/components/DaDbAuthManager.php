<?php

Yii::import('backend.controllers.DefaultController');
Yii::import('backend.controllers.ViewController');

class DaDbAuthManager extends CDbAuthManager {
  
  const OPERATION_LIST = 'list';
  const OPERATION_CREATE = 'create';
  const OPERATION_DELETE = 'delete';
  const OPERATION_EDIT = 'edit';
  const OPERATION_VIEW = 'view';
  
  private $_userAssignments = array();
  private $_authItems = array();
  private $_parentsInfo = array();
  
  public function checkMultiAccess(array $arrayOfItemName, $userId, $params=array(), $items=null) {
    $assignments=$this->getAuthAssignments($userId);
    return $this->checkMultiAccessRecursive($arrayOfItemName, $userId, $params, $assignments, $items);
  }
  
  protected function checkMultiAccessRecursive(array $arrayOfItemName, $userId, $params, $assignments, $items=null) {
    if ($items === null) {
      if (($items = $this->getAuthItemByArray($arrayOfItemName)) === array())
        return array();
    }
    Yii::trace('Checking permission "' . implode(', ',$arrayOfItemName) . '"', 'system.web.auth.DaDbAuthManager');
    if (!isset($params['userId']))
      $params['userId'] = $userId;
    $result = array();
    $falseItemsName = array();
    foreach ($items AS $item) {
      $itemName = $item->getName();
      if ($this->executeBizRule($item->getBizRule(), $params, $item->getData())) {
        if (in_array($itemName, $this->defaultRoles)) {
          $result[$itemName] = true;
          continue;
        }
        if (isset($assignments[$itemName])) {
          $assignment = $assignments[$itemName];
          if ($this->executeBizRule($assignment->getBizRule(), $params, $assignment->getData())) {
            $result[$itemName] = true;
            continue;
          }
        }
        $falseItemsName[] = $itemName;
      }
    }
    if (count($falseItemsName) == 0) return $result;

    foreach($falseItemsName as &$name)
      $name=$this->db->quoteValue($name);
    $condition = 'child IN ('.implode(', ', $falseItemsName).')';
    $rows = $this->db->createCommand()
            ->select('parent, child')
            ->from($this->itemChildTable)
            ->where($condition)
            ->queryAll();
    $parents = array();
    foreach ($rows as $row) {
      $parents[$row['parent']][$row['child']] = true;
    }
    if (count($parents) == 0) return $result;
    $checkParents = $this->checkMultiAccessRecursive(array_keys($parents), $userId, $params, $assignments);
    foreach ($checkParents AS $parent => $check) {
      $childs = $parents[$parent];
      $result = array_merge($result, $childs);
    }
    return $result;
  }

  public function getAuthItemByIdObject($idObject) {
    $condition='name LIKE :partName';
    return $this->getAuthItemByCondition($condition, array(':partName'=>'%_object_'.$idObject));
  }
  public function getAuthItemByPartName($partName) {
    $condition='name LIKE :partName';
    return $this->getAuthItemByCondition($condition, array(':partName'=>$partName.'%'));
  }
  public function getAuthItemByArray(array $names) {
    foreach($names as &$name)
      $name=$this->db->quoteValue($name);
    $condition='name IN ('.implode(', ',$names).')';
    return $this->getAuthItemByCondition($condition);
  }
  private function getAuthItemByCondition($condition, $params = array()) {
    $rows = $this->db->createCommand()
            ->select('name, type, description, bizrule, data')
            ->from(array(
                $this->itemTable,
            ))
            ->where($condition, $params)
            ->queryAll();

    $result = array();
    foreach ($rows as $row) {
      if (($data = @unserialize($row['data'])) === false)
        $data = null;
      $result[$row['name']] = new CAuthItem($this, $row['name'], $row['type'], $row['description'], $row['bizrule'], $data);
    }
    return $result;
  }

  public function getAuthItemObject($name, $idObject) {
    return $this->getAuthItem($name.'_object_'.$idObject);
  }
  public function createOperationForObject($name, $idObject, $description = '', $bizRule = null, $data = null) {
    $name = $name.'_object_'.$idObject;
    $item = parent::createOperation($name, $description, $bizRule, $data);
    if ($item == null) {
      $this->_authItems[$name] = null;
    } else {
      $this->_authItems[$name]['name'] = $item->getName();
      $this->_authItems[$name]['type'] = $item->getType();
      $this->_authItems[$name]['description'] = $item->getDescription();
      $this->_authItems[$name]['bizrule'] = $item->getBizRule();
      $this->_authItems[$name]['data'] = $item->getData();
    }
    return $item;
  }
  public function removeAuthItemObject($name, $idObject) {
    $this->removeAuthItem($name.'_object_'.$idObject);
  }
  public function checkObject($authItem, $userId, $idObject = null, $params=array()) {
    if ($idObject != null) {
      if (!isset($params['idObject']))
        $params['idObject'] = $idObject;
      return $this->checkAccess($authItem.'_object_'.$idObject, $userId, $params);
    }
    $items = $this->getAuthItemByPartName($authItem.'_object_');
    $results = array_keys($this->checkMultiAccess(array($authItem), $userId, $params, $items));
    $return = array();
    foreach ($results AS $result) {
      $return[] = str_replace($authItem.'_object_', '', $result);
    }
    return $return;
  }

  // более прикладные методы
  public function canCreateInstance($idObject, $idUser) {
    if (Yii::app()->authManager->checkObject(DaDbAuthManager::OPERATION_CREATE, $idUser, $idObject)) {
      $event = new CreateInstanceEvent(Yii::app()->controller, $idObject);
      Yii::app()->controller->raiseEvent(DefaultController::EVENT_ON_CREATE_INSTANCE, $event);
      return $event->create;
    }
    return false;
  }
  public function checkObjectInstance($authItem, $userId, $idObject, $idInstance, $checkEventWhere=true) {
    if (!$this->checkObject($authItem, $userId, $idObject, $params=array('idInstance'=>$idInstance))) {
      return false;
    }
    if ($checkEventWhere) {
      $criteria = new CDbCriteria();
      $event = new PermissionWhereEvent(Yii::app()->controller, $idObject, null);
      $event->criteria = $criteria;
      Yii::app()->controller->raiseEvent(DefaultController::EVENT_ON_PROCESS_PERMISSION_WHERE, $event);
      $where = $event->where;
      if ($where != null || $criteria->condition != null) {
        $object = DaObject::getById($idObject);
        $field = $object->getFieldByType(DataType::PRIMARY_KEY);
        $where = HText::addCondition($where, $field.'=:id');
        $criteria->addCondition($where);
        $criteria->params = array_merge($criteria->params, $event->params);
        $criteria->params[':id'] = $idInstance;
        return $object->getModel()->exists($criteria);
      }
    }
    return true;
  }

  public function checkObjectParameter($userId, $idObject, $idInstance, $idParameter) {
    if ($idObject == null) {
      return false;
    }
    if ($idParameter == null) return false;
    $object = DaObject::getById($idObject);
    $model = null;
    if (is_null($idInstance)) {
      if (!self::canCreateInstance($idObject, $userId)) return false;
    } else {
      if ($idInstance == null) return false;
      if (Yii::app()->authManager->checkObjectInstance(DaDbAuthManager::OPERATION_EDIT, $userId, $idObject, $idInstance)) {
        $model = $object->getModel()->findByIdInstance($idInstance);
      } else {
        return false;
      }
    }

    $event = new InstanceAvailableEvent(Yii::app()->controller, $model);
    Yii::app()->controller->raiseEvent(ViewController::EVENT_ON_INSTANCE_AVAILABLE, $event);
    if ($event->status != ViewController::ENTITY_STATUS_AVAILABLE) return false;

    $param = $object->getParameterObjectByIdParameter($idParameter);
    $event = new ParameterAvailableEvent(Yii::app()->controller, $model, $param);
    Yii::app()->controller->raiseEvent(ViewController::EVENT_ON_PARAMETER_AVAILABLE, $event);
    if ($event->status == ViewController::ENTITY_STATUS_NOT_VISIBLE) return false;

    return true;
  }


  public function getAuthAssignments($userId) {
    if (isset($this->_userAssignments[$userId])) return $this->_userAssignments[$userId];
    return $this->_userAssignments[$userId] = parent::getAuthAssignments($userId);
  }

  public function getAuthItem($name) {
    if (array_key_exists($name, $this->_authItems)) {
      if ($this->_authItems[$name] == null) return null;
      return new CAuthItem($this, 
              $this->_authItems[$name]['name'], 
              $this->_authItems[$name]['type'], 
              $this->_authItems[$name]['description'], 
              $this->_authItems[$name]['bizrule'], 
              $this->_authItems[$name]['data']);
    }
    $item = parent::getAuthItem($name);
    if ($item == null) {
      $this->_authItems[$name] = null;
    } else {
      $this->_authItems[$name]['name'] = $item->getName();
      $this->_authItems[$name]['type'] = $item->getType();
      $this->_authItems[$name]['description'] = $item->getDescription();
      $this->_authItems[$name]['bizrule'] = $item->getBizRule();
      $this->_authItems[$name]['data'] = $item->getData();      
    }
    return $item;
  }

  /**
   * Performs access check for the specified user.
   * This method is internally called by {@link checkAccess}.
   * @param string $itemName the name of the operation that need access check
   * @param mixed $userId the user ID. This should can be either an integer and a string representing
   * the unique identifier of a user. See {@link IWebUser::getId}.
   * @param array $params name-value pairs that would be passed to biz rules associated
   * with the tasks and roles assigned to the user.
   * Since version 1.1.11 a param with name 'userId' is added to this array, which holds the value of <code>$userId</code>.
   * @param array $assignments the assignments to the specified user
   * @return boolean whether the operations can be performed by the user.
   * @since 1.1.3
   */
  protected function checkAccessRecursive($itemName,$userId,$params,$assignments)
  {
    if(($item=$this->getAuthItem($itemName))===null)
      return false;
    Yii::trace('Checking permission "'.$item->getName().'"','system.web.auth.CDbAuthManager');
    if(!isset($params['userId']))
      $params['userId'] = $userId;
    if($this->executeBizRule($item->getBizRule(),$params,$item->getData()))
    {
      if(in_array($itemName,$this->defaultRoles))
        return true;
      if(isset($assignments[$itemName]))
      {
        $assignment=$assignments[$itemName];
        if($this->executeBizRule($assignment->getBizRule(),$params,$assignment->getData()))
          return true;
      }
      if (!isset($this->_parentsInfo[$itemName])) {
        $this->_parentsInfo[$itemName]=$this->db->createCommand()
            ->select('parent')
            ->from($this->itemChildTable)
            ->where('child=:name', array(':name'=>$itemName))
            ->queryColumn();
      }
      $parents = $this->_parentsInfo[$itemName];
      foreach($parents as $parent)
      {
        if($this->checkAccessRecursive($parent,$userId,$params,$assignments))
          return true;
      }
    }
    return false;
  }
}
