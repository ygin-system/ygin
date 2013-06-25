<?php
/* SVN FILE: $Id: rbacInitialised.php 12 2010-12-19 12:44:39Z Chris $*/
/**
* RBAC initialised view.
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 12 $
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
				jQuery(this).dialog("close");location.href="'.$this->createUrl('authItems/generate').'";
			}',
			Yii::t('RbamModule.rbam','No')=>'js:function() {
				jQuery(this).dialog("close");location.href="'.$this->createUrl('authItems/index').'";
			}',
		),
		'open'=>'js:jQuery("#rbam .throbber").removeClass("rbam-working")',
		'show'=>$module->juiShow,
		'hide'=>$module->juiHide,
	),
));
echo '<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 20px -24px;"></span>'.Yii::t('RbamModule.initialisation','RBAC Authorisation Data initialised.').'</p>';
$this->renderPartial('_generate');
$this->endWidget('zii.widgets.jui.CJuiDialog');