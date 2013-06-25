<?php
/* SVN FILE: $Id: index.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* Auth Item overview page help partial view.
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
?>
<h2>Authorisation Items</h2>
<p>This page shows all of the Authorisation Items on the RBAC system tabbed according to the type of item. Items can be paged, sorted, and filtered alphabetically.</p>
<p>The following information is shown for each Authorisation Item:</p>
<ul>
<li>Name - the name of the item</li>
<li>Description - a brief description of the item</li>
<li>Business Rule - the business rule (if any) that applies to the item</li>
<li>Data - the data (if any) that is passed to the business rule</li>
<li>Parent count - the number of parent items the item has - click to display the parent items, and again to hide them</li>
<li>Child count - the number of child items the item has - click to display the child items, and again to hide them</li>
<li>Actions - actions that can be performed on the item - Manage and Delete</li>
</ul>
<p>You can also create new items.</p>
<h3>Icons</h3>
<table>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authItemManage.png','Manage item')?></td><td>Manage an item</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authItemDelete.png','Delete item')?></td><td>Delete an item (default and RBAM roles cannot be deleted)</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authItemAdd.png','Create item')?></td><td>Create role/task/operation (depending on the active tab)</td></tr>
</table>
