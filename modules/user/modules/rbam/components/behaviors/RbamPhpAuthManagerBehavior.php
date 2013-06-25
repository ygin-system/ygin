<?php
/* SVN FILE: $Id: RbamPhpAuthManagerBehavior.php 15 2010-12-20 09:01:13Z Chris $*/
/**
* RBAM PhpAuthManager Behavior class file.
* Provides additional features used by RBAM to CPhpAuthmanager.
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 15 $
* @license		BSD License (see documentation)
*/
/**
* RBAM PhpAuthManager Behavior class
* @package		RBAM
*/
class RbamPhpAuthManagerBehavior extends RbamAuthManagerBehavior {	
	/**
	* Returns the assignments authorised for the specified item.
	* @param string the item name.
	* @return array CAuthAssignments authorised for the item
	*/
	public function getItemEAuthAssignments($name) {		
		$owner = $this->getOwner();
		$roles = array();

		if ($owner->getAuthItem($name)->getType() == CAuthItem::TYPE_ROLE)
			$roles[] = $name;

		$authItems = $this->getEAncestors($name);
		foreach ($authItems as $authItem)
			if ($authItem->getType() == CAuthItem::TYPE_ROLE)
				$roles[] = $authItem->getName();
				
		$assignments = array();
		if (!empty($roles)) {
			// get users, then all their assignments, then filter those by name
			$userIdAttribute = $this->module->userIdAttribute;
			$criteria = new CDbCriteria($this->module->userCriteria);
			$criteria->mergeWith(new CDbCriteria(array('select'=>$userIdAttribute)));
			
			$userAssignments = array();
			foreach (CActiveRecord::model($this->module->userClass)->findAll($criteria) as $user) {
				$usersAssignments[$user->$userIdAttribute] = $owner->getAuthAssignments($user->$userIdAttribute);
			}
			
			foreach ($roles as $role)
				foreach ($usersAssignments as $userAssignments)
					if (array_key_exists($role, $userAssignments))
						$assignments[] = $userAssignments[$role];
			
			foreach($assignments as &$assignment)
				$assignment->attachBehavior('RbamAuthAssignmentBehavior', array(
				'class'=>'RbamAuthAssignmentBehavior',
				'module'=>$this->module
			));
		}
				
		return $assignments;
	}
	
	/**
	* Returns the parents of the specified item.
	* If type is not given all parents are returned.
	* @param mixed name(s) of the child item(s).
	* This can be either a string or an array.
	* The latter represents a list of item names.
	* @param integer type of parents to return.
	* @return array all parent items of the child
	*/
	public function getItemEParents($names, $type=null) {
		if (is_string($names))
			$names = array($names);
		$owner = $this->getOwner();
		$parents = array();
		
		foreach ($owner->getAuthItems() as $authItem)
			foreach ($names as $name)
				if ($authItem->hasChild($name))
					$parents[] = $authItem;

		$parents = $this->filterByType($parents, $type);
		foreach($parents as &$parent)
			$parent->attachBehavior('RbamAuthItemBehavior', 'RbamAuthItemBehavior');
		return $parents;
	}
	
	/**
	* Returns items of the specified type that are children of the specified parent item.
	* If type is not given all children are returned.
	* @param mixed name(s) of the parent item(s).
	* This can be either a string or an array.
	* The latter represents a list of item names.
	* @param integer type of children to return.
	* @return array items of the specified type that are children of the parent.
	*/
	public function getItemEChildren($names, $type=null) {
		$children = $this->getOwner()->getItemChildren($names);
		$children = $this->filterByType($children, $type);
		foreach($children as &$child)
			$child->attachBehavior('RbamAuthItemBehavior', 'RbamAuthItemBehavior');
		return $children;
	}
	
	/**
	* Returns items of the specified type that are unrelated to the specified item.
	* If type is not given all unrelated items are returned.
	* @param string name of the item.
	* @param integer type of item to return
	* @return array items of the specified type that are unrelated to the item.
	*/
	public function getItemEUnrelated($name, $type=null) {
		$unrelated = $this->filterOutRelated($name, $type, $this->getOwner()->getAuthItems($type));
		foreach($unrelated as &$item)
			$item->attachBehavior('RbamAuthItemBehavior', 'RbamAuthItemBehavior');
		
		$related = array_merge($this->getEAncestors($name), $this->getEDescendants($name));
		
		return array_diff_key($unrelated, $related);
	}
	
	/**
	* Returns the number of children of the specified item.
	* @param string $name the parent item name.
	* @return int the number of child items of the parent
	*/
	public function getItemChildCount($name) {
		return count($this->getOwner()->getItemChildren($name));
	}
	
	/**
	* Returns the number of parents of the specified item.
	* @param string $name the child item name.
	* @return int the number of parent items of the child
	*/
	public function getItemParentCount($name) {
		return count($this->getItemEParents($name));
	}
	
	/**
	* Returns roles not assigned to the user, either directly or via inheritance.
	* @param mixed the user id.
	* @return array roles not assigned to the user.
	*/
	public function getEUnassignedRoles($uid) {
		$owner = $this->getOwner();
		$unassignedRoles = array();
		
		foreach ($owner->getAuthItems(CAuthItem::TYPE_ROLE) as $role)
			if (!$owner->isAssigned($role->name, $uid))
				$unassignedRoles[] = $role;
		
		foreach ($owner->defaultRoles as $defaultRole)
			unset($unassignedRoles[$defaultRole]);

		foreach($unassignedRoles as &$unassignedRole)
			$unassignedRole->attachBehavior('RbamAuthItemBehavior', 'RbamAuthItemBehavior');
			
		$assignedRoles = array();
		foreach ($owner->getAuthAssignments($uid) as $assignment)
			$assignedRoles[] = $assignment->itemName;			
		
		$childRoles = $this->getItemEChildren($assignedRoles, CAuthItem::TYPE_ROLE);

		return array_diff_key($unassignedRoles, $childRoles);
	}
	
	/**
	* Filter items by type 
	* @param array items to filter
	* @param integer type of auth items required
	* @return filtered items
	*/
	private function filterByType($items, $type) {
		if (!is_null($type)) {
			switch ($type) {
				case CAuthItem::TYPE_OPERATION:
					$items = array_filter($items, array($this,'isOperation'));
					break;
				case CAuthItem::TYPE_TASK:
					$items = array_filter($items, array($this,'isTask'));
					break;
				case CAuthItem::TYPE_ROLE:
					$items = array_filter($items, array($this,'isRole'));
					break;
			}
		}
		return $items; 
	}
	
	/**
	* Filters out relations of an item from the list of items 
	* @param string name of the item
	* @param integer type of items
	* @param array list of items to filter
	* @return array filtered items
	*/
	private function filterOutRelated($name, $type, $items) {
		foreach ($this->getItemEChildren($name, $type) as $child)
			unset($items[$child->getName()]);
		foreach ($this->getItemEParents($name, $type) as $child)
			unset($items[$child->getName()]);
		unset($items[$name]);
		return $items;
	}
	
	/**
	* Callback to filter auth items that are operations
	* @param CAuthItem the item to test
	*/
	public function isOperation($item) {
		return $item->type==CAuthItem::TYPE_OPERATION;
	}
	
	/**
	* Callback to filter auth items that are tasks
	* @param CAuthItem the item to test
	*/
	public function isTask($item) {
		return $item->type==CAuthItem::TYPE_TASK;
	}
	
	/**
	* Callback to filter auth items that are roles
	* @param CAuthItem the item to test
	*/
	public function isRole($item) {
		return $item->type==CAuthItem::TYPE_ROLE;
	} 
}