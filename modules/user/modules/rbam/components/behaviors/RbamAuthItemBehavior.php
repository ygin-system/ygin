<?php
/* SVN FILE: $Id: RbamAuthItemBehavior.php 15 2010-12-20 09:01:13Z Chris $*/
/**
* RBAM AuthItem Behavior class file.
* Provides additional features used by RBAM to CAuthItem.
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 15 $
* @license		BSD License (see documentation)
*/
/**
* RBAM AuthItem Behavior class
* @package		RBAM
*/
class RbamAuthItemBehavior extends CBehavior {
	/**
	* Returns the assignments authorised for this item.
	* @param string the item name.
	* @return array CAuthAssignments authorised for this item.
	*/
	public function getAssignments() {
		$owner = $this->getOwner();
		return $owner->getAuthManager()->getItemAssignments($owner->name);
	}		
	/**
	* Returns the parents of this item.
	* @return array all parent items of this item.
	*/
	public function getEParents($type=null) {
		$owner = $this->getOwner();
		return $owner->getAuthManager()->getItemEParents($owner->name, $type);
	}	
	/**
	* Returns items of the specified type that are children of this item.
	* @return array items of the specified type that are children of this item.
	*/
	public function getEChildren($type=null) {
		$owner = $this->getOwner();
		return $owner->getAuthManager()->getItemEChildren($owner->name, $type);
	}
	/**
	* Returns items of the specified type that are not related to this item.
	* @return array parent items of the specified type of this item.
	*/
	public function getEUnrelated($type=null) {
		$owner = $this->getOwner();
		return $owner->getAuthManager()->getItemEUnrelated($owner->name, $type);		
	}
	/**
	* Returns the number of parents of this item.
	* @return integer the number of parent items of this item.
	*/
	public function getParentCount() {
		$owner = $this->getOwner();
		return $owner->getAuthManager()->getItemParentCount($owner->name);		
	}
	/**
	* Returns the number of children of this item.
	* @return integer the number of child items of this item.
	*/
	public function getChildCount() {
		$owner = $this->getOwner();
		return $owner->getAuthManager()->getItemChildCount($owner->name);		
	}
	/**
	* Returns the number of children of this item.
	* @return integer the number of child items of this item.
	*/
	public function getUserCount() {
		$owner = $this->getOwner();
		return $owner->getAuthManager()->getItemUserCount($owner->name);		
	}
	/**
	* Returns a value indicating if this item has a business rule.
	* @return boolean true if this item has a business rule, false if not.
	*/
	public function hasBizRule() {
		return !empty($this->getOwner()->bizRule);		
	}
	/**
	* Returns a value indicating if this item has business rule data.
	* @return boolean true if this item has business rule data, false if not.
	*/
	public function hasData() {
		return !empty($this->getOwner()->Data);		
	}
}