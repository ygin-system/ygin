<?php
/* SVN FILE: $Id: generate.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* Generate Auth Item page help partial view.
* en_us version
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
?>
<h2>Generate Authorization Data</h2>
<p>This page allows you to generate authorization data – authorization items and hierarchy - based on the modules, controllers, and actions in your application that you select.</p>
<p>The modules, controllers, and actions in your application are shown in a tree on the left; click the nodes to the left of the checkboxes to expand/collapse the node.</p>
<p>Check the items you wish to generate authorization data for. All child nodes of a selected node are also selected.</p>
<p>Generated authorization items are named according to their “path”; e.g. the Blog module containing the Post controller which has the create Action will result in a role named “Blog”, a task named “Blog:Post”, and an operation named “Blog:Post:Create”.  RBAM also creates the appropriate child relationships; using the above example the “Blog:Post:Create” operation will be a child of the “Blog:Post” task, which in turn will be a child of the “Blog” role.</p>
<p>You can enter a suffix that is appended to the name of authorization items. This is for use in "ended" applications to avoid name confilcts. e.g. if you are generating items for the backend you may use the suffix "Back"; this will result in the items from the above example being named "Blog:Post:Create!Back", "Blog:Post!Back", and "Blog!Back" respectively (a suffix is used to allow sorting by name to be effective).</p>
<p>Existing authorization items are shown on the right to help you decide which, if any, new items need generating.</p>
<p>Click "Generate" to generate the authorization data.</p>
<p class="note"><b>Note:</b> RBAM will not overwrite existing authorization items.</p>
<p>When RBAM has generated the authorization data a summary of new items is shown, you are then taken to the authorization items overview.</p>
