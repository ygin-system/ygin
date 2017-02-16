<?php
/* SVN FILE: $Id: generate.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* Generate Auth Items view.
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
$module = $this->getModule();
echo '<div id="left-column" class="application">';
$this->widget('rbam.extensions.jsTree.JsTree', array(
	'data'=>$data,
	'plugins'=>array('checkbox','crrm','types'),
	'options'=>array('initially_open'=>array('root'))	
));
echo CHtml::tag('div',array('class'=>'row'),CHtml::label(Yii::t('RbamModule.rbam','Suffix'),'suffix').CHtml::textField('suffix','',array('id'=>'suffix')));
echo CHtml::tag('div',array('id'=>'generate','class'=>'row buttons'),CHtml::ajaxButton(Yii::t('RbamModule.rbam','Generate'), '', array(
	'async'=>'false',
	'type'=>'post',
	'data'=>'js:"suffix="+jQuery("#suffix").val()+"&"+jQuery(".jstree-checked, .jstree-undetermined").map(function(index){
			jThis=jQuery(this);
			return "items["+index+"]="+jThis.attr("id")+"&types["+index+"]="+jThis.attr("rel");
		}).get().join("&")',
	'beforeSend'=>'js:function(){var $generate =jQuery("#generate");jQuery("input",$generate).hide();$generate.addClass("rbam-working");}',
	'success'=>'js:function(data){
		jQuery("#generate").removeClass("rbam-working");
		var jDone = jQuery("#rbam-dialog-done");
		jDone.html(jDone.html().replace(/(<\/span>).*?(<\/p>)/i,"$1"+data.content+"$2").replace(/(ui-icon-).*?("|\s+)/i,"$1"+(data.status?"circle-check":"info")+"$2")).dialog("open");
	}'
)));
echo '</div>';
echo '<div id="right-column">';
$tabs = array();
$generate=true;
foreach($authItems as $type=>$dataProvider):
	$tabs[$this->type($type)] = array(
		'title'=>$this->type($type, true, true, true)." (<span>{$dataProvider->totalItemCount}</span>)",
		'content'=>$this->renderPartial('_indexTab', compact('dataProvider', 'type', 'generate'), true)
	);	
endforeach;

$this->widget('system.web.widgets.CTabView', compact('tabs'));
echo '</div>';
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'rbam-dialog-done',
	'options'=>array(
		'dialogClass'=>'rbam-dialog',
		'autoOpen'=>false,
		'open'=>'js:function(){window.setTimeout(\'jQuery("#rbam-dialog-done").dialog("close");\', '.$module->showConfirmation.')}',
		'title'=>$this->pageTitle,
		'buttons'=>array(
			Yii::t('RbamModule.rbam','OK')=>'js:function(){jQuery(this).dialog("close");}'
		),
		'close'=>'js:function() {
			location.href="'.$this->createUrl('index').'";
		}',
		'modal'=>true,
		'draggable'=>false,
		'resizable'=>false,
		'show'=>$module->juiShow,
		'hide'=>$module->juiHide
	)
));
echo '<p><span class="ui-icon ui-icon-{icon}" style="float:left; margin:0 7px 20px -24px;"></span>{content}</p>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
