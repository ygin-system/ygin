<?php

class ViewGeneratorModule extends DaWebModuleAbstract {

	protected $_urlRules = array(
	  'viewGenerator/<id:\d+>' => 'viewGenerator/default/view',
	  'viewGenerator' => 'viewGenerator/default/index',
    'html/<view:\w+>' => 'viewGenerator/html/index',
    'admin/html/<view:\w+>' => 'viewGenerator/html/index',
	);
	
	public function init() {
		$this->setImport(array(
			$this->id.'.models.*',
			$this->id.'.components.*',
		));
	}

}
