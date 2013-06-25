<?php
/* SVN FILE: $Id: confirm.php 15 2010-12-20 09:01:13Z Chris $*/
/**
* Confirm RBAC initialisation view.
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 15 $
* @license		BSD License (see documentation)
*/
echo '<div class="throbber"></div>';
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
		'width'=>300,
		'buttons'=>array(
			Yii::t('RbamModule.rbam','Yes')=>'js:function() {
				jQuery(this).dialog("close");
				jQuery("#rbam .throbber").addClass("rbam-working");
				jQuery("#initialise").val('.RbamInitialiser::STATUS_INITIALISE_RBAC.');
				jQuery("#dialog-form").submit();
			}',
			Yii::t('RbamModule.rbam','No')=>'js:function() {
				jQuery(this).dialog("close");
				jQuery("#rbam .throbber").addClass("rbam-working");
				jQuery("#initialise").val('.RbamInitialiser::STATUS_INITIALISE_RBAM.');
				jQuery("#dialog-form").submit();
			}',
		),
		'show'=>$module->juiShow,
		'hide'=>$module->juiHide,
	)
));

echo '<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px -24px;"></span>'.Yii::t('RbamModule.initialisation', 'RBAM has detected existing RBAC authorisation data.').'</p>';
echo '<p>'.Yii::t('RbamModule.initialisation', 'Do you wish to re-initialise RBAC Authorisation Data?').'</p>';
echo '<p class="ui-state-error"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px -24px;"></span>'.Yii::t('RbamModule.initialisation', 'WARNING: Re-initialising will overwrite all existing RBAC Authorisation Data.').'</p>';
echo CHtml::beginForm('','post',array('id'=>'dialog-form','style'=>'display:none;'));
echo CHtml::hiddenField('initialise','',array('id'=>'initialise'));
echo CHtml::endForm();

$this->endWidget('zii.widgets.jui.CJuDialog');