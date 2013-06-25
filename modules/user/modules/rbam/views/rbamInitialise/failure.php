<?php
/* SVN FILE: $Id: failure.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* RBAC initialisation failed view.
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
?>
<div class="failure">
	<h2><?php echo Yii::t('RbamModule.initialisation','RBAC Initialisation Failed'); ?></h2>
	<p><?php echo $status; ?></p>
</div>