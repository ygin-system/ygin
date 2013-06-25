<?php
/* SVN FILE: $Id: _relations.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* Relations partial view.
* Used to render parents and children of an auth item when drilling up or down.
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
$module = $this->getModule();
$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'template'=>"{items}",
	'columns'=>array(
		array(
			'name'=>'name',
			'type'=>'raw',
			'header'=>Yii::t('RbamModule.rbam','Name'),
			'headerHtmlOptions'=>array('scope'=>'col'),
			'htmlOptions'=>array('class'=>'item-name'),
		),
		array(
			'name'=>'type',
			'value'=>'$this->grid->owner->type($data->type, true, true)',
			'header'=>Yii::t('RbamModule.rbam','Type'),
			'headerHtmlOptions'=>array('scope'=>'col')
		),
		array(
			'name'=>'description',
			'type'=>'ntext',
			'header'=>Yii::t('RbamModule.rbam','Description'),
			'headerHtmlOptions'=>array('scope'=>'col'),
		),
		array(
			'type'=>'raw',
			'value'=>'($data->hasBizRule()?"<div class=\"ui-icon ui-icon-check\" title=\"".str_replace(\'"\',"\'",$data->bizRule)."\"></div>":"")',
			'header'=>Yii::t('RbamModule.rbam','Biz Rule'),
			'cssClassExpression'=>'"boolean ".($data->hasBizRule()?"true":"false")',
		),
		array(
			'type'=>'raw',
			'value'=>'($data->hasData()?"<div class=\"ui-icon ui-icon-check\" title=\"".str_replace(\'"\',"\'",$data->data)."\"></div>":"")',
			'header'=>Yii::t('RbamModule.rbam','Data'),
			'cssClassExpression'=>'"boolean ".($data->hasData()?"true":"false")'
		),
		array(
			'class'=>'CLinkColumn',
			'labelExpression'=>'$data->parentCount',
			'urlExpression'=>'$this->grid->getOwner()->createUrl("authItems/getParents",array("item"=>$data->name))',
			'linkHtmlOptions'=>array('onclick'=>'return false;'),
			'header'=>Yii::t('RbamModule.rbam','Parents'),
			'headerHtmlOptions'=>array('scope'=>'col'),
			'htmlOptions'=>array('class'=>'parents number', 'title'=>Yii::t('RbamModule.rbam','Click to toggle parent items'))
		),
		array(
			'class'=>'CLinkColumn',
			'labelExpression'=>'$data->childCount',
			'urlExpression'=>'$this->grid->getOwner()->createUrl("authItems/getChildren",array("item"=>$data->name))',
			'linkHtmlOptions'=>array('onclick'=>'return false;'),
			'header'=>Yii::t('RbamModule.rbam','Children'),
			'headerHtmlOptions'=>array('scope'=>'col'),
			'htmlOptions'=>array('class'=>'children number', 'title'=>Yii::t('RbamModule.rbam','Click to toggle child items'))
		),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}',
			'updateButtonUrl'=>'array("manage", "item"=>$data->name)',
			'updateButtonImageUrl'=>"{$module->baseScriptUrl}/images/authItemManage.png",
			'updateButtonOptions'=>array('class'=>'manage', 'title'=>Yii::t('RbamModule.rbam','Manage this item')),
			'visible'=>Yii::app()->user->checkAccess($module->authItemsManagerRole)
		)
	),
));
