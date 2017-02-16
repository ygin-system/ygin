<?php
/* SVN FILE: $Id: RbamAuthAssignmentBehavior.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* RBAM AuthAssignment Behavior class file.
* Provides additional features used by RBAM to CAuthAssignment.
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
/**
* RBAM AuthAssignment Behavior class
* @package		RBAM
*/
class RbamAuthAssignmentBehavior extends CBehavior {
	/**
	* @property CModule The RBAM module
	*/
	public $module;
	private $_item;
	private $_user;
	
	/**
	* Attach this behavior
	* @param CAuthAssignment owner
	*/
	public function attach($owner) {
		parent::attach($owner);
		$this->_item = Yii::app()->getAuthManager()->getAuthItem($this->getOwner()->itemName);
		$this->_item->attachBehavior('RbamAuthItemBehavior', 'RbamAuthItemBehavior');
		$this->_user = $this->module->getUser($owner->userId);
	}
	/**
	* Returns items of the specified type that are children of the assignment's authorisation item.
	* @return array items of the specified type that are children of the assignment's authorisation item.
	*/
	public function getItemEChildren($type=null) {
		return $this->_item->getEChildren($type);		
	}
	/**
	* Returns items of the specified type that are parents of the assignment's authorisation item.
	* @return array items of the specified type that are parents of the assignment's authorisation item.
	*/
	public function getItemEParents($type=null) {
		return $this->_item->getEParents($type);		
	}	
	/**
	* Returns items of the specified type that are not related to the assignment's authorisation item.
	* @return array parent items of the specified type of the assignment's authorisation item.
	*/
	public function getItemEUnrelated($type=null) {
		return $this->_item->getEUnrelated($type);		
	}
	/**
	* Returns the number of parents of the assignment's authorisation item.
	* @return integer the number of parent items of the assignment's authorisation item.
	*/
	public function getItemParentCount() {
		return $this->_item->getParentCount();		
	}
	/**
	* Returns the number of children of the assignment's authorisation item.
	* @return integer the number of child items of the assignment's authorisation item.
	*/
	public function getItemChildCount() {
		return $this->_item->getChildCount();		
	}
	/**
	* Returns the description of the assignment's authorisation item.
	* @return string the description of the assignment's authorisation item.
	*/
	public function getItemDescription() {		
		return $this->_item->description;		
	}
	/**
	* Returns the name of the assignment's user.
	* @return string the name of the assignment's user.
	*/
	public function getUserName() {		
		return $this->_user->rbamName;		
	}
	/**
	* Returns a value indicating if this assignment has a business rule.
	* @return boolean true if this assignment has a business rule, false if not.
	*/
	public function hasBizRule() {
		return !empty($this->getOwner()->bizRule);		
	}
	/**
	* Returns a value indicating if this assignment has business rule data.
	* @return boolean true if this assignment has business rule data, false if not.
	*/
	public function hasData() {
		return !empty($this->getOwner()->Data);		
	}
}
