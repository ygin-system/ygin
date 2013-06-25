<?php
/* SVN FILE: $Id: _assignments.php 17 2010-12-21 19:09:15Z Chris $*/
/**
* Assignments partial view.
* Renders the assignments in the "manage" view
*
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 17 $
* @license		BSD License (see documentation)
*/
$module = $this->getModule();
$hasAuthAssignmentsManagerRole = Yii::app()->getUser()->checkAccess($this->getmodule()->authAssignmentsManagerRole);;
echo '<div id="item-assignments">';
echo CHtml::tag('h2', array(), Yii::t('RbamModule.rbam','Assignments'));
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'assignments',
	'dataProvider'=>new CArrayDataProvider(
		array_values($this->authManager->getItemEAuthAssignments($item->name)),
		array(
			'keyField'=>'itemName',
			'pagination'=>array(
				'pageSize'=>(is_null($this->module->relationshipsPageSize)
						?$this->module->pageSize
						:$this->module->relationshipsPageSize
				)
			),
	)),
	'summaryText'=>Yii::t('RbamModule.rbam','{start}-{end} of {count} {items}', array('{items}'=>Yii::t('RbamModule.rbam','assignments'))),
	'rowCssClassExpression'=>'($row%2?"even":"odd").($data->itemName==="'.$item->name.'"?" direct":"")',
	'columns'=>array(
		array(
			'name'=>'userName',
			'header'=>Yii::t('RbamModule.rbam','User'),
			'headerHtmlOptions'=>array('colspan'=>2,'scope'=>'col'),
			'htmlOptions'=>array('class'=>'viewable'),
			'value'=>'$data->userName',
			'type'=>'raw',
		),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view}',
			'headerHtmlOptions'=>array('style'=>'display:none;'),
			'htmlOptions'=>array('class'=>'button-column view-button'),
			'viewButtonUrl'=>'array("authAssignments/userRoles", "uid"=>$data->userId)',
			'viewButtonOptions'=>array('title'=>Yii::t('RbamModule.rbam','View roles assigned to this user')),
			'viewButtonImageUrl'=>"{$module->baseScriptUrl}/images/userView.png",
			'visible'=>$hasAuthAssignmentsManagerRole
		),
		array(
			'name'=>'itemName',
			'type'=>'raw',
			'header'=>Yii::t('RbamModule.rbam','Role'),
			'headerHtmlOptions'=>array('colspan'=>2,'scope'=>'col'),
			'htmlOptions'=>array('class'=>'viewable item-name'),
			'value'=>'$data->itemName',
		),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view}',
			'headerHtmlOptions'=>array('style'=>'display:none;'),
			'htmlOptions'=>array('class'=>'button-column view-button'),
			'viewButtonUrl'=>'array("authAssignments/roleUsers", "role"=>$data->itemName)',
			'viewButtonOptions'=>array('title'=>Yii::t('RbamModule.rbam','View users with this role assigned')),
			'viewButtonImageUrl'=>"{$module->baseScriptUrl}/images/authItemView.png",
			'visible'=>$hasAuthAssignmentsManagerRole
		),
		array(
			'name'=>'itemDescription',
			'type'=>'ntext',
			'header'=>Yii::t('RbamModule.rbam','Description'),
			'headerHtmlOptions'=>array('scope'=>'col'),
		),
		array(
			'class'=>'CLinkColumn',
			'labelExpression'=>'$data->itemParentCount',
			'urlExpression'=>'$this->grid->getOwner()->createUrl("authItems/getParents",array("item"=>$data->itemName))',
			'linkHtmlOptions'=>array('onclick'=>'return false;'),
			'header'=>Yii::t('RbamModule.rbam','Parents'),
			'headerHtmlOptions'=>array('scope'=>'col'),
			'htmlOptions'=>array('class'=>'parents number', 'title'=>Yii::t('RbamModule.rbam','Click to toggle parent items'))
		),
		array(
			'class'=>'CLinkColumn',
			'labelExpression'=>'$data->itemChildCount',
			'urlExpression'=>'$this->grid->getOwner()->createUrl("authItems/getChildren",array("item"=>$data->itemName))',
			'linkHtmlOptions'=>array('onclick'=>'return false;'),
			'header'=>Yii::t('RbamModule.rbam','Children'),
			'headerHtmlOptions'=>array('scope'=>'col'),
			'htmlOptions'=>array('class'=>'children number', 'title'=>Yii::t('RbamModule.rbam','Click to toggle child items'))
		),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}',
			'header'=>Yii::t('RbamModule.rbam','Role Actions'),
			'headerHtmlOptions'=>array('scope'=>'col'),
			'updateButtonUrl'=>'array("authItems/manage", "item"=>$data->itemName)',
			'updateButtonOptions'=>array('title'=>Yii::t('RbamModule.rbam','Manage this role')),
			'updateButtonImageUrl'=>"{$module->baseScriptUrl}/images/authItemManage.png"
		),
		array(
			'name'=>'bizrule',
			'type'=>'raw',
			'header'=>Yii::t('RbamModule.rbam','Business Rule'),
			'footer'=>Yii::t('RbamModule.rbam','Business Rule and Data apply to the assignment'),
			'footerHtmlOptions'=>array('colspan'=>2, 'style'=>'text-align:center;')
		),
		array(
			'name'=>'data',
			'type'=>'raw',
			'header'=>Yii::t('RbamModule.rbam','Data'),
			'footerHtmlOptions'=>array('style'=>'display:none;')
		),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}{revoke}',
			'header'=>Yii::t('RbamModule.rbam','Assignment Actions'),
			'headerHtmlOptions'=>array('scope'=>'col'),
			'updateButtonUrl'=>'array("authAssignments/update", "role"=>$data->itemName, "uid"=>$data->userId)',
			'updateButtonOptions'=>array('class'=>'update','title'=>Yii::t('RbamModule.rbam','Update this assignment')),
			'updateButtonImageUrl'=>"{$module->baseScriptUrl}/images/assignmentUpdate.png",
			'buttons'=>array(
				'revoke'=>array(
					'url'=>'$this->grid->getOwner()->createUrl("authAssignments/revoke",array("role"=>$data->itemName,"uid"=>$data->userId))',
					'click'=>'function() {
						var jDialog = jQuery("#rbam-dialog-confirm");
						var jThis = jQuery(this);
						var jRow = jThis.parents("tr:first");
						jRow.addClass("selected");
						jDialog.html(jDialog.html().replace(/(.+? ").+?(::).+?(")/i,"$1"+jQuery("td:first",jRow).text()+"$2"+jQuery("td:eq(2)",jRow).text()+"$3"));
						jDialog.data("url", jThis.attr("href"));
						jDialog.dialog("open");
						return false;
					}',
					'imageUrl'=>"{$module->baseScriptUrl}/images/assignmentRevoke.png",
					'options'=>array('class'=>'revoke','title'=>Yii::t('RbamModule.rbam','Revoke this assignment')),
				),
				'update'=>array(
					'click'=>'function() {
						var jThis = jQuery(this);
						var jRow = jThis.parents("tr:first");
						var strHref = jThis.attr("href");
						jRow.addClass("selected");
						jQuery("#AuthAssignment_userName").val(jQuery("td:first",jRow).text());
						jQuery("#AuthAssignment_itemName").val(jQuery("td:eq(2)",jRow).text());
						jQuery("#AuthAssignment_bizrule").html(jQuery.trim(jQuery("td:eq(8)",jRow).text()));
						jQuery("#AuthAssignment_data").html(jQuery.trim(jQuery("td:eq(9)",jRow).text()));
						jQuery("#AuthAssignment_userId").val(strHref.substr(strHref.search(/\d+$/)));
						jQuery("#rbam-dialog-form").data("row",jRow).dialog("open");
						jQuery("#AuthAssignment_bizrule").focus();
						return false;
					}'
				)
			),
			'visible'=>$hasAuthAssignmentsManagerRole
		)
	),
));
echo '</div>';

if ($hasAuthAssignmentsManagerRole):
	$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		'id'=>'rbam-dialog-confirm',
		'options'=>array(
			'dialogClass'=>'rbam-dialog',
			'autoOpen'=>false,
			'title'=>Yii::t('RbamModule.rbam','Revoke Assignment'),
			'buttons'=>array(
				Yii::t('RbamModule.rbam','Revoke')=>'js:function(){
					jQuery.getJSON(
						jQuery(this).data("url"),
						function(data) {
							var jDone = jQuery("#rbam-dialog-done");
							jQuery("#rbam-dialog-confirm").dialog("close");
							jDone.html(jDone.html().replace(/(<\/span>).*?(<\/p>)/i,"$1"+data.content+"$2"));
							jDone.dialog("option","title","'.Yii::t('RbamModule.rbam','Assignment Revoked').'");
							jDone.dialog("open");
						}
					);
				}',
				Yii::t('RbamModule.rbam','Cancel')=>'js:function(){jQuery(this).dialog("close");}'
			),
			'modal'=>true,
			'draggable'=>false,
			'resizable'=>false,
			'show'=>$module->juiShow,
			'hide'=>$module->juiHide
		)
	));
	echo '<p><span class="ui-icon ui-icon-help" style="float:left; margin:0 7px 20px -24px;"></span>'.Yii::t('RbamModule.rbam','Revoke "{user}::{role}" assignment?').'</p><p>'.Yii::t('RbamModule.rbam','Revoking the assignment does not delete the role or the user, and the user can be reassigned the role at any time.').'</p><p>'.Yii::t('RbamModule.rbam','Click "Revoke" to continue.').'</p>';
	$this->endWidget('zii.widgets.jui.CJuiDialog');

	$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		'id'=>'rbam-dialog-form',
		'options'=>array(
			'dialogClass'=>'rbam-dialog',
			'autoOpen'=>false,
			'title'=>Yii::t('RbamModule.rbam','Update Assignment'),
			'buttons'=>array(
				Yii::t('RbamModule.rbam','Update')=>'js:function() {
					var jForm = jQuery("form", this);
					jQuery(".error.summary", jForm).slideUp().remove();
					jQuery(".error", jForm).removeClass("error");
					jQuery.post(
						"'.$this->createUrl('authAssignments/update').'",
						jForm.serialize(),
						function(data) {
							if (data.errors==undefined) {
								var jDone = jQuery("#rbam-dialog-done");
								jDone.html(jDone.html().replace(/(<\/span>).*?(<\/p>)/i,"$1"+data.content+"$2"));
								jDone.dialog("option","title","'.Yii::t('RbamModule.rbam','Assignment Updated').'");
								jDone.dialog("open");
								jQuery("#rbam-dialog-form").dialog("close");
							}
							else {
								jForm.prepend($.fn.rbam.getErrorSummary("AuthAssignment", "'.Yii::t('RbamModule.rbam','Please correct the following errors:').'" ,data.errors));
							}
						}
					);
				}',
				Yii::t('RbamModule.rbam','Cancel')=>'js:function() {
					jQuery(this).data("row").removeClass("selected");
					jQuery(this).dialog("close");
				}'
			),
			'modal'=>true,
			'draggable'=>false,
			'resizable'=>false,
			'show'=>$module->juiShow,
			'hide'=>$module->juiHide
		)
	));
	echo $assignmentForm;
	$this->endWidget('zii.widgets.jui.CJuiDialog');
endif;
