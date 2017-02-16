<?php
/* SVN FILE: $Id: RbamDbAuthManagerBehavior.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* RBAM DbAuthManager Behavior class file.
* Provides additional features used by RBAM to CDbAuthmanager.
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
/**
* RBAM DbAuthManager Behavior class
* @package		RBAM
*/
class RbamDbAuthManagerBehavior extends RbamAuthManagerBehavior {
	/**
	* Returns the assignments authorised for the specified item.
	* @param string the item name.
	* @return array CAuthAssignments authorised for the item
	*/
	public function getItemEAuthAssignments($name) {
		$owner = $this->getOwner();
		$roles = array();

		if ($owner->getAuthItem($name)->getType() == CAuthItem::TYPE_ROLE)
			$roles[] = $owner->db->quoteValue($name);

		$authItems = $this->getEAncestors($name);
		foreach ($authItems as $authItem)
			if ($authItem->getType() == CAuthItem::TYPE_ROLE)
				$roles[] = $owner->db->quoteValue($authItem->getName());

		$assignments = array();
				
		if (!empty($roles)) {
			$sql = "SELECT* FROM {$owner->assignmentTable} WHERE itemname IN (" .
					join(', ', $roles) . ')';
			foreach($owner->db->createCommand($sql)->queryAll() as $row) {
				$assignment = new CAuthAssignment($this, $row['itemname'], $row['userid'],	$row['bizrule'], unserialize($row['data']));
				$assignment->attachBehavior('RbamAuthAssignmentBehavior', array(
					'class'=>'RbamAuthAssignmentBehavior',
					'module'=>$this->module				
				));
				$assignments[] = $assignment;
			} // foreach
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
		if (empty($names))
			return array();
		$owner = $this->getOwner();
		if(is_string($names))
				$condition = 'child='.$owner->db->quoteValue($names);
		else if(is_array($names)) {
				foreach($names as &$name)
						$name = $owner->db->quoteValue($name);
				$condition = 'child IN ('.implode(', ',$names).')';
		}
		$condition .= " AND name=parent";
		if (is_int($type))
			$condition .= " AND type=$type";
		$sql="SELECT name, type, description, bizrule, data FROM {$owner->itemTable}, {$owner->itemChildTable} WHERE $condition ORDER BY type DESC, name";
		return $this->itemsFromSql($owner, $sql);
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
		if (empty($names))
			return array();
		$owner = $this->getOwner();
		if(is_string($names))
				$condition = 'parent='.$owner->db->quoteValue($names);
		else if(is_array($names)) {
				foreach($names as &$name)
						$name = $owner->db->quoteValue($name);
				$condition = 'parent IN ('.implode(', ',$names).')';
		}
		$condition .= " AND child=name";
		if (is_int($type))
			$condition .= " AND type=$type";
		$sql="SELECT name, type, description, bizrule, data FROM {$owner->itemTable}, {$owner->itemChildTable} WHERE $condition ORDER BY type DESC, name";
		return $this->itemsFromSql($owner, $sql);
	}
	
	/**
	* Returns items of the specified type that are unrelated to the specified item.
	* If type is not given all unrelated items are returned.
	* @param string name of the item.
	* @param integer type of item to return
	* @return array items of the specified type that are unrelated to the item.
	*/
	public function getItemEUnrelated($name, $type=null) {
		$owner = $this->getOwner();
		$condition1 = 'child='.$owner->db->quoteValue($name);
		$subQuery1 = "SELECT parent AS related FROM {$owner->itemChildTable} WHERE $condition1";
		$condition2 = 'parent='.$owner->db->quoteValue($name);
		$subQuery2 = "SELECT child AS related FROM {$owner->itemChildTable} WHERE $condition2";
		$condition = "name NOT IN ($subQuery1 UNION $subQuery2) AND name!=".$owner->db->quoteValue($name);
		if (is_int($type))
			$condition .= " AND type=$type";
		$sql="SELECT name, type, description, bizrule, data FROM {$owner->itemTable} WHERE $condition ORDER BY type DESC, name";
		$unrelated = $this->itemsFromSql($owner, $sql);
		
		$related = array_merge($this->getEAncestors($name), $this->getEDescendants($name));
		
		return array_diff_key($unrelated, $related);
	}
	
	/**
	* Returns the number of children of the specified item.
	* @param string $name the parent item name.
	* @return int the number of child items of the parent
	*/
	public function getItemChildCount($name) {
		$owner = $this->getOwner();
		$condition='parent='.$owner->db->quoteValue($name);
		$sql = "SELECT COUNT(child) FROM {$owner->itemChildTable} WHERE $condition";
		return $owner->db->createCommand($sql)->queryScalar();
	}
	
	/**
	* Returns the number of parents of the specified item.
	* @param string $name the child item name.
	* @return int the number of parent items of the child
	*/
	public function getItemParentCount($name) {
		$owner = $this->getOwner();
		$condition='child='.$owner->db->quoteValue($name);
		$sql = "SELECT COUNT(parent) FROM {$owner->itemChildTable} WHERE $condition";
		return $owner->db->createCommand($sql)->queryScalar();
	}
	
	/**
	* Returns roles not assigned to the user.
	* @param mixed the user id.
	* @return array roles not assigned to the user.
	*/
	public function getEUnassignedRoles($uid) {
		$owner = $this->getOwner();
		$condition = 'type='.CAuthItem::TYPE_ROLE." AND name NOT IN(SELECT itemName FROM {$owner->assignmentTable} WHERE userid=$uid)";
		$sql = "SELECT* FROM {$owner->itemTable} WHERE $condition";
		$unassignedRoles = $this->itemsFromSql($owner, $sql);
		
		foreach ($owner->defaultRoles as $defaultRole)
			unset($unassignedRoles[$defaultRole]);
		
		$assignedRoles = array();
		foreach ($owner->getAuthAssignments($uid) as $assignment)
			$assignedRoles[] = $assignment->itemName;			
		
		$childRoles = $this->getItemEChildren($assignedRoles, CAuthItem::TYPE_ROLE);

		return array_diff_key($unassignedRoles, $childRoles);
	}
	
	/**
	* Executes an SQL command and returns auth items with the RBAMAuthItemBehavior attached.
	* @param CDbAuthManager owner
	* @param string sql to execute
	* @return array CAuthItems with RBAMAuthItemBehavior attached
	*/
	private function itemsFromSql($owner, $sql) {
		$items=array();
		foreach($owner->db->createCommand($sql)->queryAll() as $row) {
				if(($data=@unserialize($row['data']))===false)
					$data=null;
				$item = new CAuthItem($owner,$row['name'],$row['type'],$row['description'],$row['bizrule'],$data);
				$item->attachBehavior('RbamAuthItemBehavior', 'RbamAuthItemBehavior');
				$items[$row['name']]=$item;
		}
		return $items;		
	}
}
