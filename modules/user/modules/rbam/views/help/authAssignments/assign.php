<?php
/* SVN FILE: $Id: assign.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* Assign roles to user page help partial view.
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
?>
<h2>Assign Roles to User</h2>
<p>This page is used to assign roles to a user. Available roles, i.e. roles that are not assigned and are not children of roles assigned to the user, are shown; they can be paged, sorted, and filtered alphabetically.</p>
<p class="note"><b>Note:</b> Default roles are not listed as they cannot be assigned to users.</p>
<p>The following information is shown for each role:</p>
<ul>
<li>Name – the name of the role</li>
<li>Description – a brief description of the role</li>
<li>Business rule – the business rule (if any) applicable to the role</li>
<li>Data – the data (if any) passed to the business rule</li>
<li>Parent count – the number of items to which this role is a child.  Click to see the parent items, and again to hide them</li>
<li>Child count – the number of child items the role has.  Click to see the child items, and again to hide them</li>
<li>Checkbox – click the checkbox to assign the role to the current user</li>
</ul>
<p>On assigning a role (clicking its checkbox) a pop-up form is displayed where the business rule and data for the assignment are entered if required. Click “Assign” to complete the assignment, or “Cancel” to cancel the it. The list of unassigned roles is updated when a role is assigned.</p>
<p class="note"><b>Note:</b> Roles other than the assigned role will be removed from the list if they are children of the assigned role.</p>
