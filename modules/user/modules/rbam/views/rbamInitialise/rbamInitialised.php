<?php
/* SVN FILE: $Id: rbamInitialised.php 15 2010-12-20 09:01:13Z Chris $*/
/**
* RBAC initialisation skipped view.
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 15 $
* @license		BSD License (see documentation)
*/
$module = $this->getModule();
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'rbam-dialog',
	'options'=>array(
		'dialogClass'=>'rbam-dialog',
		'title'=>$this->pageTitle,
		'autoOpen'=>true,
		'modal'=>true,
		'draggable'=>false,
		'resizable'=>false,
		'buttons'=>array(
			Yii::t('RbamModule.rbam','Yes')=>'js:function() {
				jQuery("#dialog").dialog("close");location.href="'.$this->createUrl('authItems/generate').'";
			}',
			Yii::t('RbamModule.rbam','No')=>'js:function() {
				jQuery("#dialog").dialog("close");location.href="'.$this->createUrl('authItems/index').'";
			}',
		),
		'open'=>'js:jQuery("#rbam .throbber").removeClass("rbam-working")',
		'show'=>$module->juiShow,
		'hide'=>$module->juiHide,
	),
));
echo '<p>'.Yii::t('RbamModule.initialisation','No changes have been made to existing RBAC Authorisation Data.').'</p>';
echo '<p>'.Yii::t('RbamModule.initialisation','RBAM roles have been added if not already present.').'</p>';
$this->renderPartial('_generate');
$this->endWidget('zii.widgets.jui.CJuiDialog');