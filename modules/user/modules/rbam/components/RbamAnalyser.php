<?php
/* SVN FILE: $Id: RbamAnalyser.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* RBAM Analyser class file.
* Analyses the application to get details of modules, controllers and actions.
* 
* Credits: Code is based on the {@link http://www.yiiframework.com/extension/metadata Metadata extension} by Vitaliy Stepanenko
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
/**
* RBAM Analyser class
* @package		RBAM
*/
class RbamAnalyser extends CApplicationComponent {
	/**
	* @property mixed modules to exclude from analysis.
	* Either an array or comma delimited string of module ids.
	*/
	public $exclude;
	
	/**
	* Initialises the component 
	*/
	public function init() {
		if (is_string($this->exclude)) {
			$this->exclude = explode(',',$this->exclude);
			array_walk($this->exclude,array($this,'trim'));
		}
	}
	
	/**
	* Analyse the application
	* @return array modules controllers and actions in the application
	*/
	public function run() {
		return $this->analyseModule(Yii::app());
	}
		
	/**
	* Returns an array of modules within the specified module
	* @param CModule the module to analyse
	* @return array modules
	*/
	private function analyseModule($module) {
		$_module = new stdClass();		
		$_module->id = ucfirst($module->getId());
		$_module->controllers = $this->getControllers($module);
		$_module->modules = $this->getModules($module);
		return $_module; 
	}
		
	/**
	* Returns an array of modules within the specified module
	* @param CModule the module to analyse
	* @return array modules
	*/
	private function getModules($module) {
		$modules = array();
		
		foreach ($module->getModules() as $id=>$configuration) {
			if (in_array($id,$this->exclude))
				continue;
			$_module = $module->getModule($id);
			if ($_module)
				$modules[] = $this->analyseModule($_module);
		}
		
		return $modules; 
	}
	
	/**
	* Get controllers in the specified module. 
	* @param CModule the module to analyse
	* @return array controllers in the module
	*/
	private function getControllers($module) {
		$controllers = array();
		$path=$module->getControllerPath();
		if (is_dir($path)) {
			foreach (array_filter(scandir($path),array($this,'isController')) as $controller) {
				$id = str_ireplace('controller.php','',$controller);
				$controllers[] = (object)array(
					'id'=>$id,
					'actions'=>$this->getActions($id, $path)
				);
			}			
		}
		return $controllers;
	}
		
	/**
	* Get controller actions.
	* Analyse the source to avoid including the controller and so class name
	* clashes between controllers with the same name in different modules.
	* @param string controller name
	* @param string path to controller
	* @return array controller actions
	*/
	private function getActions($controller, $path) {
		$controller .= 'Controller.php';
		$actions = array();
		
		$source = file_get_contents($path.DIRECTORY_SEPARATOR.$controller);		
		preg_match_all('/function (?:(actions)|action(\w+))\(/i', $source, $matches, PREG_SET_ORDER);
		
		foreach ($matches as $match) {
			if (!empty($match[1])) {
				$actionsMethod = '';
				$braces = 0;
				$pos = stripos($source, 'function actions()') + strlen('function actions()');
				
				while (($c=$source[++$pos]) !== '{');
				do {
					$c = $source[$pos++];
					if ($c === '{')
						$braces++;
					elseif ($c === '}')
						$braces--;
					$actionsMethod .= $c;							
				} while ($braces > 0);
				
				preg_match_all('/([\'"])(\w+)\1.*?class/si', $actionsMethod, $classes, PREG_SET_ORDER);
				
				foreach ($classes as $class)
					$actions[] = (object)array('id'=>ucfirst($class[2]));
			}
			else
				$actions[] = (object)array('id'=>ucfirst($match[2]));
		}
		return $actions;
	}

	/**
	* Used filter an array of files & directories for controllers
	* @param string filename
	*/
	private function isController($a) {
		return stripos($a,'Controller.php')!==false;
	}
	
	/**
	* Trim string callback 
	* @param string $str
	*/
	private function trim(&$str) {
		$str = trim($str);
	}
}