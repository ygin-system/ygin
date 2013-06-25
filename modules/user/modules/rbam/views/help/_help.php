<?php
/* SVN FILE: $Id: _help.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* Page help partial view.
* Content is rendered from the appropriate partial view.
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
$module = $this->getModule();
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'rbam-dialog-help',
	'options'=>array(
		'dialogClass'=>'rbam-dialog',
		'title'=>Yii::t('RbamModule.help','Role Based Access Manager Help'),
		'autoOpen'=>false,
		'minWidth'=>800,
		'height'=>500,
		'modal'=>true,
		'show'=>$module->juiShow,
		'hide'=>$module->juiHide
	)
));
$this->renderPartial("/help/{$this->id}/{$this->action->id}");
$this->endWidget('zii.widgets.jui.CJuiDialog');
echo CHtml::link('Help', '#', array('class'=>'help', 'title'=>Yii::t('RbamModule.help','Show help for this page')));
Yii::app()->getClientScript()->registerScript(
	'rbamHelp','jQuery("a.help").live("click",function(){
		jQuery("#rbam-dialog-help").dialog("open");
	});'
);