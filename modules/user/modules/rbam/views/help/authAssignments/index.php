<?php
/* SVN FILE: $Id: index.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* Users page help partial view.
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
?>
<h2>Users</h2>
<p>This page shows all of the users in the system that can be assigned roles. Users can be paged, sorted, and filtered alphabetically.</p>
<p>The following information is shown for each User:</p>
<ul>
<li>Name – the name of the user</li>
<li>Roles count – the number of roles currently assigned to the user</li>
<li>Actions – buttons to view the roles assigned <?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/userView.png','Roles assigned to the user')?> and assign roles<?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentAdd.png','Assign roles to the user')?> to the user</li>
</ul>

