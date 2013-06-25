<?php
/* SVN FILE: $Id: _indexTab.php 15 2010-12-20 09:01:13Z Chris $*/
/**
* Index Tab partial view.
* Used to render auth items on the appropriate tab.
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 15 $
* @license		BSD License (see documentation)
*/
$baseScriptUrl = $this->getModule()->baseScriptUrl;
$this->widget('rbam.extensions.alphapager.ApGridView', array(
	'dataProvider'=>$dataProvider,
	'id'=>'grid-'.$this->type($type),
	'template'=>"{alphapager}\n{summary}\n{items}\n{pager}",
	'summaryText'=>Yii::t('RbamModule.rbam','{start}-{end} of <span>{count}</span> {items}', array('{items}'=>$this->type($type, true, true, true))),
	'columns'=>array(
		array(
			'name'=>'name',
			'type'=>'raw',
			'value'=>'$data->name',
			'header'=>Yii::t('RbamModule.rbam','Name'),
			'headerHtmlOptions'=>array('scope'=>'col'),
			'htmlOptions'=>array('class'=>'item-name')
		),
		array(
			'name'=>'description',
			'type'=>'ntext',
			'header'=>Yii::t('RbamModule.rbam','Description'),
			'headerHtmlOptions'=>array('scope'=>'col'),
		),
		array(
			'name'=>'bizrule',
			'type'=>'raw',
			'header'=>Yii::t('RbamModule.rbam','Business Rule'),
			'headerHtmlOptions'=>array('scope'=>'col'),
			'visible'=>empty($generate)
		),
		array(
			'name'=>'data',
			'type'=>'raw',
			'header'=>Yii::t('RbamModule.rbam','Data'),
			'headerHtmlOptions'=>array('scope'=>'col'),
			'visible'=>empty($generate)
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
			'template'=>'{update}{deleteItem}',
			'header'=>Yii::t('RbamModule.rbam','Actions'),
			'headerHtmlOptions'=>array('scope'=>'col'),
			'footer'=>CHtml::link(CHtml::image("$baseScriptUrl/images/authItemAdd.png",Yii::t('RbamModule.rbam','Create {type}', array('{type}'=>$this->type($type, true, true)))), array('create', 'type'=>$type), array('class'=>'add', 'title'=>Yii::t('RbamModule.rbam','Create {type}', array('{type}'=>$this->type($type, true, true))))),
			'updateButtonUrl'=>'array("manage", "item"=>$data->name)',
			'updateButtonImageUrl'=>"$baseScriptUrl/images/authItemManage.png",
			'updateButtonOptions'=>array('class'=>'manage', 'title'=>Yii::t('RbamModule.rbam','Manage this {type}', array('{type}'=>$this->type($type, true)))),
			'buttons'=>array(
				'deleteItem'=>array(
					'url'=>'array("delete", "item"=>$data->name)',
					'imageUrl'=>"$baseScriptUrl/images/authItemDelete.png",
					'options'=>array('class'=>'delete','title'=>Yii::t('RbamModule.rbam','Delete this {type}', array('{type}'=>$this->type($type, true)))),
					'visible'=>$type.'!=='.CAuthItem::TYPE_ROLE.'||!in_array($data->name,array("'.join('","',array_values($this->getModule()->getDefaultRoles())).'"));'
				)
			),
			'visible'=>empty($generate)
		)
	),
	'afterAjaxUpdate'=>'function(){$.fn.rbam.updateTabCounts(jQuery("#rbam"));}'
));
