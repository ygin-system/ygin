<?php
/* SVN FILE: $Id: manage.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* Manage Auth Item page help partial view.
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
?>
<h2>Manage an Authorisation Item</h2>
<p>This page is where you manage all aspects of an Authorisation Item.</p>
<p>On the left is a form that can be used to update the item. Make the required changes and click "Update".</p>
<p class="note"><b>Note:</b> Renaming the default and RBAM roles is not recommended.<br/>By default the name of these roles is read only. If you wish to change the name of one of these roles, double click the name to make it editable.</p>
<p>On the right you can view and manage the relationships – parents and children – of the item.  There are three relationship areas:</p>
<ul>
<li>Parents – items to which the current item is a child</li>
<li>Children – items that are children of the current item</li>
<li>Unrelated – items that are not related to the current item, i.e. not an ancestor or descendant of the current item</li>
</ul>
<p>Each area displays its items in tabs according to type; this means that not all types may be shown for parents and/or children as it depends on the type of the current item; for example, if the current item is a Role, only other Roles can be its parents.</p>
<p>The content of each tab can be paged, sorted, and filtered alphabetically.</p>
<p>The following information is shown for each Authorisation Item:</p>
<ul>
<li>Name – name of the item. Use this to "drag and drop" and manage relationships</li>
<li>Description – a brief description of the item</li>
<li>Business Rule – a check mark is shown if the item has a business rule; hover to see the rule</li>
<li>Data – a check mark is shown if the item has data to be passed to the business rule; hover to see the data</li>
<li>Parent count – the number of items to which the item is a child. Click to see the parent items</li>
<li>Child count – the number of child items the item has. Click to see the child items</li>
<li>Actions – button to manage the item <?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authitemManage.png','Manage item')?></li>
</ul>
<h3>Managing Relationships</h3>
<p>Managing relationships is simply a case of dragging and dropping items to or from the Unrelated area onto or out of the Parents or Children areas.  The drag handle of an item is its name which will have an orange background while being dragged.  Area(s) where the item can be dropped will turn yellow then green when an item is in the area.</p>
<p>The relationship areas are drop targets - not the tabs - so it does not matter which tab is active in the drop area.</p>
<h4>Add a Relationship</h4>
<p>To add an item as a child or parent of the current item, drag an unrelated item (click and drag on the name) to the Parents or Children area of the screen; the relationship is created immediately and the relationships and permission areas updated accordingly.</p>
<h4>Remove a Relationship</h4>
<p>To remove a relationship, drag an item from the Parents or Children areas to the Unrelated area; the relationship is removed immediately and the relationships and permission areas updated.</p>
<p class="note"><b>Note:</b> When adding or removing relationships, counts of Unrelated items may change for types of items other than that of the item added/removed as a child/parent, and its type count may change by more than one. This is because relations (descendants and ancestors) of the item are taken into account.<br/>
For example, if you add Task T as a child of Role R, Role R inherits all the permissions of Task T and its descendants ; i.e. Task T’s descendants become descendants of Role R meaning that they are now related to it and so removed from the list of unrelated items.</p>
<h3>Assignments</h3>
<p>This shows the users that have permission for the current item and the role assignments by which they are granted permission.</p>
<p>The following information is shown for each user::role assignment:
<ul>
<li>User – the name of the user with permission for the current item.  Clicking the “view” button <?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/userView.png','Show user roles')?> (only available if you you have Auth Assignments Manager permission) will display the roles assigned to the user</li>
<li>Role – the name of the role by which the user is granted permission for the current item.  Clicking the “view” button <?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authItemView.png','Show role users')?> (only available if you have Auth Assignments Manager permission) will display the users with the role assigned</li>
<li>Description – a brief description of the role</li>
<li>Parent count – the number of roles to which this role is a child. Click to see the parent items</li>
<li>Child count – the number of child roles the role has. Click to see the child items, and again to hide them</li>
<li>Role Action – a button to manage the role</li>
<li>Business rule – the business rule (if any) applicable to the user::role assignment, and again to hide them</li>
<li>Data – the data (if any) passed to the business rule</li>
<li>Assignment Actions (only available if you are assigned the Auth Assignments Manager role) – buttons to update the business rule and/or data for the assignment <?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentUpdate.png','Edit assignment')?>, and revoke <?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentRevoke.png','Revoke assignment')?> the assignment</li>
</ul>
<h3>Icons</h3>
<table>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authItemManage.png','Manage item')?></td><td>Manage an item</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/userView.png','Roles assigned to the user')?></td><td>Roles assigned to the user</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authItemView.png','Users with role assigned')?></td><td>Users with role assigned</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentUpdate.png','Edit assignment')?></td><td>Edit assignment</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentRevoke.png','Revoke assignment')?></td><td>Revoke assignment</td></tr>
</table>
