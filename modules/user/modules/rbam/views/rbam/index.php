<?php
/* SVN FILE: $Id: index.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* RBAM home page view.
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
$module = $this->getModule();
$user = Yii::app()->getUser();
echo '<div id="left-column">';
echo CHtml::image($module->baseScriptUrl.'/images/rbam.png','Role Base Access Manager');
echo '</div>';
echo '<div id="right-column" class="select">';
if ($user->checkAccess($module->authAssignmentsManagerRole) || $user->checkAccess($module->authItemsManagerRole)):
	echo '<h2>'.Yii::t('RbamModule.rbam','Select a task').'</h2>';
	echo '<ul>';
	if ($user->checkAccess($module->authAssignmentsManagerRole)):
		echo '<li>'.CHtml::link(Yii::t('RbamModule.rbam','Manage Authorisation Assignments').' &#187;',array('authAssignments/index')).'</li>';
	endif;
	if ($user->checkAccess($module->authItemsManagerRole)):
		echo '<li>'.CHtml::link(Yii::t('RbamModule.rbam','Manage Authorisation Items').' &#187;',array('authItems/index')).'</li>';
	endif;
	if ($module->development && $user->checkAccess($module->rbacManagerRole)):
		echo '<li>'.CHtml::link(Yii::t('RbamModule.rbam','Generate Authorisation Data').' &#187;',array('authItems/generate')).'</li>';
		if (!empty($module->initialise)):
			echo '<li>'.CHtml::link(Yii::t('RbamModule.initialisation','Re-Initialise RBAC').' &#187;',array('rbamInitialise/initialise')).'</li>';
		endif;
	endif;
else:
	$this->renderPartial('_notInitialised');
endif;
echo '</ul>';
echo '</div>';
