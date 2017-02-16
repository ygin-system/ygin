<?php
/* SVN FILE: $Id: roleUsers.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* Users with a role assigned page help partial view.
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
?>
<h2>Users with Role Assigned</h2>
<p>This page shows the users with a given role assigned, either directly or by inheritance.</p>
<p>The following information is shown for each User:</p>
<ul>
<li>Name – the name of the user. The “view” button<?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/userView.png','Roles assigned to user')?> shows the roles assigned to a user</li>
<li>Role – the name of the role. The “view” button<?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authItemView.png','Users with role assigned')?> shows the users with the role assigned</li>
<li>Description – a brief description of the role</li>
<li>Parent count – the number of items to which this role is a child.  Click to see the parent items, and again to hide them</li>
<li>Child count – the number of child items the role has.  Click to see the child items, and again to hide them</li>
<li>Role Actions – button  to manage the role<?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authItemManage.png','Manage the role')?> (only available if you have Auth Items Manager permission)</li>
<li>Business rule – the business rule (if any) applicable to the assignment</li>
<li>Data – the data (if any) passed to the business rule</li>
<li>Assignment Actions – buttons to update the business rule and/or data for the assignment<?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentUpdate.png','Edit assignment')?>, and revoke the assignment<?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentRevoke.png','Revoke assignment')?>.</li>
</ul>
<h3>Icons</h3>
<table>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authItemManage.png','Manage item')?></td><td>Manage an item</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/userView.png','Roles assigned to the user')?></td><td>Roles assigned to the user</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authItemView.png','Users with role assigned')?></td><td>Users with role assigned</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentUpdate.png','Edit assignment')?></td><td>Edit assignment</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentRevoke.png','Revoke assignment')?></td><td>Revoke assignment</td></tr>
</table>