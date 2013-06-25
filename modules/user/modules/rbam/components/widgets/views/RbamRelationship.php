<?php
/* SVN FILE: $Id: RbamRelationship.php 15 2010-12-20 09:01:13Z Chris $*/
/**
* RBAM Relationships widget view.
* Displays auth items of a given relationship to an item.
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 15 $
* @license		BSD License (see documentation)
*/
$owner->widget('rbam.extensions.alphapager.ApGridView', array(
	'dataProvider'=>$dataProvider,
	'template'=>"{alphapager}\n{summary}\n{items}\n{pager}",
	'summaryText'=>Yii::t('RbamModule.rbam','{start}-{end} of <span>{count}</span> {items}', array('{items}'=>$owner->type($type, true, true, true))),
	'columns'=>array(
		array(
			'name'=>'name',
			'type'=>'raw',
			'header'=>Yii::t('RbamModule.rbam','Name'),
			'headerHtmlOptions'=>array('class'=>'sortable','scope'=>'col'),
			'htmlOptions'=>array('class'=>'item-name'),
		),
		array(
			'name'=>'description',
			'type'=>'ntext',
			'header'=>Yii::t('RbamModule.rbam','Description'),
			'headerHtmlOptions'=>array('class'=>'sortable','scope'=>'col'),
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
			'name'=>'userCount',
			'header'=>Yii::t('RbamModule.rbam','Users'),
			'headerHtmlOptions'=>array('scope'=>'col'),
			'htmlOptions'=>array('class'=>'users number')
		),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}',
			'updateButtonUrl'=>'array("manage", "item"=>$data->name)',
			'updateButtonImageUrl'=>$owner->getModule()->baseScriptUrl.'/images/authItemManage.png',
			'updateButtonOptions' =>	array("title"=>Yii::t('RbamModule.rbam','Manage this {type}', array('{type}'=>$owner->type($type, true)))),
		)
	),
	'afterAjaxUpdate'=>'$.fn.rbam.relationships.afterGridUpdate'
));
