<?php
/* SVN FILE: $Id: form.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* Form to manage and create Auth Items view.
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
$module = $this->getModule();
$cs = Yii::app()->getClientScript();
echo '<div id="left-column">';
echo $form;
if ($this->action->id==='manage'):
	echo Chtml::link(Yii::t('RbamModule.rbam','Done'), $this->createUrl('index'), array('class'=>'button btn'));
	$cs->registerScript('makeNameEditable', 'jQuery("#AuthItem_name").dblclick(function(){jQuery(this).removeAttr("readonly");});'); // makes default role names editable
endif;
echo '</div>';
if ($this->action->id==='manage'):
	echo '<div id="right-column">';
	echo CHtml::tag('h3', array(), Yii::t('RbamModule.rbam','Manage Relationships'));
	foreach(array('parents','children','unrelated') as $relationship):
		$this->widget('rbam.components.widgets.RbamRelationship', compact('item', 'relationship'));
	endforeach;
	Yii::app()->getClientScript()->registerScript('relationships', "jQuery().rbam.relationships('{$item->name}',".CJavaScript::encode($this->config()).');');
	echo '</div>';
	$this->renderPartial('_assignments', compact('item', 'assignmentForm'));
endif;

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'rbam-dialog-done',
	'options'=>array(
		'dialogClass'=>'rbam-dialog',
		'autoOpen'=>false,
		'open'=>'js:function() {
			timer=window.setTimeout(\'jQuery("#rbam-dialog-done").dialog("close");\', '.$module->showConfirmation.');'.
			($this->action->id==='manage'?
				'if (jQuery(this).data("redirect")==undefined) {
					$.fn.yiiGridView.update("assignments");
				}':'').
		'}',
		'close'=>'js:function(){
			window.clearTimeout(timer);
			if (jQuery(this).data("redirect")!=undefined) {
				location.href = jQuery(this).data("redirect");
			}
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

$cs->registerScript('submitForm', 'var jForm = jQuery("#yw0");
	jQuery("input[type=\"submit\"]", jForm).click(function() {	
	jQuery(".error.summary", jForm).slideUp().remove();
	jQuery(".error", jForm).removeClass("error");
	jQuery.post(
		window.location.href,
		jForm.serialize(),
		function(data) {
			if (data.errors==undefined) {
				var jDone = jQuery("#rbam-dialog-done");
				jDone.html(jDone.html().replace(/(<\/span>).*?(<\/p>)/i,"$1"+data.content+"$2"));
				jDone.dialog("option","title","'.($this->action->id==='manage'?Yii::t('RbamModule.rbam','Auth Item Updated'):Yii::t('RbamModule.rbam','Auth Item Created')).'");
				if (data.redirect!=undefined) {
					jDone.data("redirect", data.redirect);
				}
				jDone.dialog("open");
			}
			else {
				jForm.prepend($.fn.rbam.getErrorSummary("AuthItem", "'.Yii::t('RbamModule.rbam','Please correct the following errors:').'" ,data.errors));
			}
		},
		"json"
	);
	return false;
});');

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
