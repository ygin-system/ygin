<?php
/* SVN FILE: $Id: RbamAuthManagerBehavior.php 15 2010-12-20 09:01:13Z Chris $*/
/**
* RBAM AuthManager Behavior class file.
* Provides additional features used by RBAM to CAuthmanager.
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 15 $
* @license		BSD License (see documentation)
*/
/**
* RBAM AuthManager Behavior class
* @package		RBAM
*/
class RbamAuthManagerBehavior extends CBehavior {
	/**
	* @property CModule The RBAM module
	*/
	public $module;
	
	/**
	* Returns the auth item with the specified name.
	* @param string $name the name of the item
	* @return CAuthItem the auth item. Null if the item cannot be found.
	*/
	public function getEAuthItem($name) {
		$item = $this->getOwner()->getAuthItem($name);
		if ($item)
			$item->attachBehavior('RbamAuthItemBehavior', 'RbamAuthItemBehavior');
		return $item;
	}
	
	/**
	* Returns auth items of the specified type with RbamAuthItemBehavior attached
	* @param integer the item type (0: operation, 1: task, 2: role).
	* Defaults to null, meaning returning all items regardless of their type.
	* @return array Auth items of the specified type
	*/
	public function getEAuthItems($type=null) {
		$items = $this->getOwner()->getAuthItems($type);
		foreach($items as &$item)
			$item->attachBehavior('RbamAuthItemBehavior', 'RbamAuthItemBehavior');
		return $items;
	}
	
	/**
	* Returns the number of roles the specified user is assigned to.
	* @return integer the number of roles the specified user is assigned to.
	*/
	public function getRoleCount($uid) {
		return count($this->getOwner()->getAuthAssignments($uid));		
	}
	
	/**
	* Returns the number of distinct users with permission for the specified item.
	* @return integer the number of users with permission for the specified item.
	*/
	public function getItemUserCount($name) {
		$users = array();
		foreach ($this->getOwner()->getItemEAuthAssignments($name) as $assignment)
			if (!in_array($assignment->userId, $users))
				$users[] = $assignment->userId;
		return count($users);		
	}
	
	/**
	* Returns the user's assignments.
	* @param mixed the user id.
	* @return array CAuthAssignments assigned to the user
	*/
	public function getEAuthAssignments($uid) {
		$assignments = $this->getOwner()->getAuthAssignments($uid);
		foreach($assignments as &$assignment)
			$assignment->attachBehavior('RbamAuthAssignmentBehavior', array(
			'class'=>'RbamAuthAssignmentBehavior',
			'module'=>$this->module
		));
		return $assignments;
	}

	/**
	* Returns the ancestors of the specified item(s).
	* Typically called with a single item name. An array of names is used during
	* recursive calls to find earlier ancestors.
	* @param mixed name(s) of the item(s).
	* @return array ancestor items of the item(s)
	*/
	public function getEAncestors($name) {
		$ancestors = array();
		do {
			$parents = $this->getItemEParents($name);
			$ancestors = array_merge($ancestors, $parents);
			$name = array();
			foreach ($parents as $parentName=>$parent) {
				$name[] = $parentName;
			} // foreach
		} while (!empty($parents));
		return $ancestors;
	}
	
	/**
	* Returns the descendants of the specified item(s).
	* Typically called with a single item name. An array of names is used during
	* recursive calls to find later descendants.
	* @param mixed name(s) of the item(s).
	* @return array descendant items of the item(s)
	*/
	public function getEDescendants($name) {
		$descendants = array();
		do {
			$children = $this->getItemEChildren($name);
			$descendants = array_merge($descendants, $children);
			$name = array();
			foreach ($children as $childName=>$child) {
				$name[] = $childName;
			} // foreach
		} while (!empty($children));
		return $descendants;
	}
}
