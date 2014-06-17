<?php

class ObjectExportModule extends DaWebModuleAbstract {

	protected $_urlRules = array(
	  'objectExport/<id:\d+>' => 'objectExport/default/view',
	  'objectExport' => 'objectExport/default/index',
	);
	
	public function init() {
		$this->setImport(array(
			$this->id.'.models.*',
			$this->id.'.components.*',
		));
		$ass = Yii::getPathOfAlias('objectExport.assets');
		Yii::app()->clientScript->registerScriptFile(
		  Yii::app()->assetManager->publish($ass. "/script.js")    
		);
		Yii::app()->clientScript->registerCssFile(
		  Yii::app()->assetManager->publish($ass. "/style.css")
		);
	}

}
