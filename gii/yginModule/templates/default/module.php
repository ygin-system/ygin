<?php echo "<?php\n"; ?>

class <?php echo $this->moduleClass; ?> extends DaWebModuleAbstract {

	protected $_urlRules = array(
	  '<?php echo $this->moduleID; ?>/<id:\d+>' => '<?php echo $this->moduleID; ?>/default/view',
	  '<?php echo $this->moduleID; ?>' => '<?php echo $this->moduleID; ?>/default/index',
	);
	
	public function init() {
		$this->setImport(array(
			$this->id.'.models.*',
			$this->id.'.components.*',
		));
	}

}
