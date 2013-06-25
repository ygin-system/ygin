<?php
/* SVN FILE: $Id: index.php 17 2010-12-21 19:09:15Z Chris $*/
/**
* Auth Items overview view.
*
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 17 $
* @license		BSD License (see documentation)
*/
$module = $this->getModule();
$tabs = array();
foreach($authItems as $type=>$dataProvider):
	$tabs[$this->type($type)] = array(
		'title'=>$this->type($type, true, true, true)." (<span>{$dataProvider->totalItemCount}</span>)",
		'content'=>$this->renderPartial('_indexTab', compact('dataProvider', 'type'), true)
	);
endforeach;

$this->widget('system.web.widgets.CTabView', array('tabs'=>$tabs, 'activeTab'=>($active?$this->type($active):null)));

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'rbam-dialog-confirm',
	'options'=>array(
		'dialogClass'=>'rbam-dialog',
		'autoOpen'=>false,
		'buttons'=>array(
			Yii::t('RbamModule.rbam','Delete')=>'js:function(){
				jQuery.getJSON(
					jQuery(this).data("url"),
					function(data) {
						var jDone = jQuery("#rbam-dialog-done");
						jQuery("#rbam-dialog-confirm").dialog("close");
						jDone.html(jDone.html().replace(/(<\/span>).*?(<\/p>)/i,"$1"+data.content+"$2")).dialog("open");
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
echo '<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px -24px;"></span>'.Yii::t('RbamModule.rbam','Delete "{item}" ?').'</p><p>'.Yii::t('RbamModule.rbam','The item will be permanently deleted and cannot be recovered.').'</p><p>'.Yii::t('RbamModule.rbam','Click "Delete" to continue.').'</p>';
$this->endWidget('zii.widgets.jui.CJuiDialog');

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'rbam-dialog-done',
	'options'=>array(
		'dialogClass'=>'rbam-dialog',
		'autoOpen'=>false,
		'open'=>'js:function() {
			jDialog = jQuery("#rbam-dialog-done");
			timer=window.setTimeout(\'jDialog.dialog("close");\', '.$module->showConfirmation.');
			$.fn.yiiGridView.update("grid-"+jDialog.data("type"));
		}',
		'close'=>'js:function(){window.clearTimeout(timer);}',
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

Yii::app()->getClientScript()->registerScript(
	'revoke','jQuery("a.delete").live("click",function() {
		var jDialog = jQuery("#rbam-dialog-confirm");
		var jDoneDialog = jQuery("#rbam-dialog-done");
		var jThis = jQuery(this);
		var jRow = jThis.parents("tr:first");
		var strType = jThis.parents(".view:first").attr("id");
		jDoneDialog.data("type", strType);
		strType = strType.substring(0,1).toUpperCase()+strType.substr(1);
		jRow.addClass("selected");
		jDoneDialog.dialog("option","title",strType+" Deleted");
		jDialog.dialog("option","title","Delete "+strType);
		jDialog.html(jDialog.html().replace(/(.+? ").+?(")/i,"$1"+jQuery("td:first",jRow).text()+"$2"));
		jDialog.data("url", jThis.attr("href"));
		jDialog.dialog("open");
		return false;
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
