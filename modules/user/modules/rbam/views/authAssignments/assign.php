<?php
/* SVN FILE: $Id: assign.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* Create Auth Assignments view.
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
$module = $this->getModule();
echo '<div class="view">';
$this->widget('rbam.extensions.alphapager.ApGridView', array(
	'id'=>'roles',
	'dataProvider'=>$dataProvider,
	'template'=>"{alphapager}\n{summary}\n{items}\n{pager}",
	'summaryText'=>Yii::t('RbamModule.rbam','{start}-{end} of <span>{count}</span> {items}', array('{items}'=>Yii::t('RbamModule.rbam','roles'))),
	'columns'=>array(
		array(
			'name'=>'name',
			'type'=>'raw',
			'header'=>Yii::t('RbamModule.rbam','Name'),
			'headerHtmlOptions'=>array('scope'=>'col'),
			'htmlOptions'=>array('class'=>'item-name'),
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
		),
		array(
			'name'=>'data',
			'type'=>'raw',
			'header'=>Yii::t('RbamModule.rbam','Data'),
			'headerHtmlOptions'=>array('scope'=>'col'),
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
			'class'=>'CCheckBoxColumn',
			'header'=>Yii::t('RbamModule.rbam','Assign'),
			'headerHtmlOptions'=>array('scope'=>'col'),
			'value'=>'$data->name'
		)
	)
));
echo '</div>';

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'rbam-dialog-done',
	'options'=>array(
		'dialogClass'=>'rbam-dialog',
		'autoOpen'=>false,
		'title'=>Yii::t('RbamModule.rbam','Role Assigned'),
		'open'=>'js:function(){
			$.fn.yiiGridView.update("roles");
			timer=window.setTimeout(\'jQuery("#rbam-dialog-done").dialog("close");\', '.$module->showConfirmation.');
		}',
		'close'=>'js:function(){
			window.clearTimeout(timer);
		}',
		'buttons'=>array(
			Yii::t('RbamModule.rbam','OK')=>'js:function(){jQuery(this).dialog("close");}'
		),
		'modal'=>true,
		'draggable'=>false,
		'resizable'=>false,
		'show'=>$module->juiShow,
		'hide'=>$module->juiHide
	)
));
echo '<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 20px -24px;"></span>{content}</p>';
$this->endWidget('zii.widgets.jui.CJuiDialog');

$userId = $module->userIdAttribute;

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'rbam-dialog-form',
	'options'=>array(
		'dialogClass'=>'rbam-dialog',
		'autoOpen'=>false,
		'title'=>Yii::t('RbamModule.rbam','Assign Role'),
		'buttons'=>array(
			Yii::t('RbamModule.rbam','Assign')=>'js:function() {
				var jForm = jQuery("form", this);
				jQuery(".error.summary", jForm).slideUp().remove();
				jQuery(".error", jForm).removeClass("error");
				jQuery.post(
					"'.$this->createUrl('assign', array('uid'=>$user->$userId)).'",
					jForm.serialize(),
					function(data) {
						if (data.errors==undefined) {
							var jDone = jQuery("#rbam-dialog-done");
							jDone.html(jDone.html().replace(/(<\/span>).*?(<\/p>)/i,"$1"+data.content+"$2")).dialog("open");
							jQuery("#rbam-dialog-form").dialog("close");
						}
						else {
							jForm.prepend($.fn.rbam.getErrorSummary("AuthAssignments", "'.Yii::t('RbamModule.rbam','Please correct the following errors:').'" ,data.errors));
						}
					}
				);
			}',
			Yii::t('RbamModule.rbam','Cancel')=>'js:function() {
				var jThis = jQuery(this);
				var jEl = jThis.data("element");
				jEl.removeAttr("checked");
				jEl.parents("tr:first").removeClass("selected");
				jThis.dialog("close");
			}'
		),
		'modal'=>true,
		'draggable'=>false,
		'resizable'=>false,
		'show'=>$module->juiShow,
		'hide'=>$module->juiHide
	)
));
echo $form;
$this->endWidget('zii.widgets.jui.CJuiDialog');

Yii::app()->getClientScript()->registerScript('assign', 
	'jQuery("input:checkbox").live("click",function() {	
		var jThis = jQuery(this);
		var strRole = jThis.val();
		jQuery("#AuthAssignment_itemName").val(strRole);
		jQuery("#AuthAssignment_userId").val('.$user->$userId.');
		jQuery("#AuthAssignment_userName").val("'.$user->rbamName.'");
		// save the checkbox in the dialog then open the form
		jQuery("#rbam-dialog-form").data("element",jThis).dialog("open");
		jQuery("#AuthAssignment_bizrule").focus();	
	});'	
);

$cs = Yii::app()->getClientScript();
$cs->registerScript(
	'rbamShowChildren','jQuery("td.children").live("click",function(){
		$.fn.rbam.showChildren(this);
	});'
);
$cs->registerScript(
	'rbamShowParents','jQuery("td.parents").live("click",function(){
		$.fn.rbam.showParents(this);
	});'
);