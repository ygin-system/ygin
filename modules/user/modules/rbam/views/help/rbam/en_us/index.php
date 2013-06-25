<?php
/* SVN FILE: $Id: index.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* RBAM home page help partial view.
* en_us version
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
?>
<h2>Role Based Access Manager</h2>
<p>The Role Based Access Manager (RBAM) provides total management of your Role Based Access Control (RBAC) system.<p>
<p>From here you can manage either the Authorization Items and/or Role Assignments to users, depending on what permissions you have.</p>
<h2>Role Based Access Control</h2>
<p>Role Based Access Control (RBAC) is a method of granting users permission to do something based on the role(s) they are assigned to. Permissions are actually granted to roles, either directly or by inheritance, which are then assigned to the appropriate users. Typically, the permissions for a given role rarely change compared to the user assignments to the role. A role can be assigned to many users and a user may have many roles (note: it is often easier to manage a system where a user is assigned one role that obtains permissions of other roles via inheritance).</p>
<h3>Authorization Items</h3>
<p>Authorization Items are the building blocks of the RBAC systems; they grant permission to do something, either directly or by inheriting the permissions of child authorization items.</p>
<p>An Authorization Item is uniquely defined by its name.</p>
<p>This RBAC system has three levels of Authorization Items: <em><?php echo CHtml::link('Roles', '#help-roles'); ?></em> at the top level, then <em><?php echo CHtml::link('Tasks', '#help-tasks'); ?></em>, and <em><?php echo CHtml::link('Operations', '#help-operations'); ?></em> at the lowest level.</p>
<p>An Authorization Hierarchy is built using the Authorization Items. An Authorization Item can have child Authorization Items of the same or lower level and inherits the permissions of its children. An Authorization Item can have many children and an Authorization Item may be the child of many other Authorization Items (technically, this makes the authorization hierarchy a partial-order graph; it is possible to create flat and tree hierarchies using RBAC).</p>
<p>The Authorization Hierarchy grants permissions in terms of an application's structure by defining the roles that people do, the tasks performed in the roles, and the operations needed to perform the tasks (Note: RBAC can use roles and tasks only, or just roles, making it a good solution even if your application has fairly simple authorization requirements). This allows a flexible yet powerful authorization system to be created; RBAM  makes it easy to create and manage your system.</p>
<h4 id="help-roles">Roles</h4>
<p>Roles are the top level Authorization Items and are assigned to users (tasks and operations are not). Roles can be equated to job titles. Using a blog application as an example; possible roles might be "Editor" (can approve, delete, etc. all posts), "Assistant Editor" (can approve posts up to a certain size - slightly contrived, but you'll see why later), and "Author" (can create posts and edit their own).</p>
<p>Roles can have other roles, tasks, and operations as children.</p>
<h5>Default Roles</h5>
<p>The RBAC system can have "default roles". These roles are not explicitly assigned to users, rather the RBAC system checks them automatically for all users. RBAM defines two default roles: "Guest" - the default role for all users that are not logged in, and "Authorized" - the default role for all users that are logged in (RBAM can be configured to use different names).</p>
<p>RBAM also has some roles that it defines for its own use (again, RBAM can be configured to use different names): "RBAC Manager" - manages Auth Items and Role Assignments, "Auth Assignments Manager" - manages Role Assignments, and "Auth Items Manager" - manages Auth Items. (the Auth Assignments Manager and Auth Items Manager roles are children of the RBAC Manager role which inherits the permissions of both.)</p>
<h4 id="help-tasks">Tasks</h4>
<p>Tasks are the mid-tier of the authorization hierarchy; they are what people do in a role. Example tasks in our blog application might be "Manage Posts" - a child of the "Editor" role, and "Write Posts" - a child of the Author role.</p>
<p>Tasks can have other tasks and operations as children.</p>
<h4 id="help-operations">Operations</h4>
<p>Operations are the lowest level in the authorization hierarchy; they are the actions used to carry out a task. Operations in the blog example might be "Create Post" and "Edit Own Post" (this requires a <em><?php echo CHtml::link('Business Rule', '#help-business-rules'); ?>)</em>) as children of the "Write Posts" task, "Approve Post" - child of the "Manage Posts" task and the "Assistant Editor" role, and "Edit Post" and "Delete Post" - children of the "Manage Posts" task.</p>
<p>Operations can only have other operations as children.</p>
<h3 id="help-business-rules">Business Rules</h3>
<p>An Authorization Item may have a <em>business rule</em>. A business rule is a piece of PHP code that is executed when checking access for the item; it must return <code>true</code> to grant permission; the "Guest" and "Authorized" roles use business rules to check whether the user is logged in.</p>
<p>The business rule can refer to two variables: <em>$params</em> and <em>$data</em>. <em>$params</em> comes from the application and is used to pass in parameters required by the business rule.</p>
<p>In the blog example, we want to ensure that users can only edit posts they created and that they cannot do so once a post is approved. To do this we use a business rule that is passes the post in the <em>$params</em> variable;  something like:</p>
<pre>return Yii::app()->user-&gt;id==$params["post"]-&gt;authorID && !$params["post"]-&gt;approved;</pre>
<p>Earlier we defined the "Assistant Editor" role; users with the role can approve posts upto a certain length. To check this we use both the <em>$params</em> and <em>$data</em> variables in a business rule for the Assistant Editor role along the lines of:</p>
<pre>return strlen($params["post"]-&gt;content)&lt;=$data;</pre>
<h3 id="help-data">Data</h3>
<p>An Authorization Item can have additional data that is referred to in the business rule using the <em>$data</em> variable. In the above example <em>$data</em> is the maximum length of post the Assistant Editor role can approve and so is an integer value.</p>
<h3>Authorization Assignments</h3>
<p>Authorization assignments assign roles to users. The assignment can have a business rule and data to customise the permissions granted by the role for a particular user.</p>