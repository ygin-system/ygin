<?php
/* SVN FILE: $Id: RbamInitialiseController.php 15 2010-12-20 09:01:13Z Chris $*/
/**
* Initialisation Controller class file.
* Manages the initialisation of RBAC Authorisation Data.
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 15 $
* @license		BSD License (see documentation)
*/
/**
* Initialisation Controller class
* @package		RBAM
*/
class RbamInitialiseController extends RbamController {
	/**
	* @property CAuthManager The auth manager component
	*/
	public $authManager;
	/**
	* @property string the default acion for this controller
	*/
	public $defaultAction='initialise';
	/**
	* @var RBAMInitialiser The initialiser component
	*/
	private $_initialiser; 

	/**
	* @return array action filters
	*/
	public function filters() {
		return array('accessControl');
	}

	/**
	* Specifies the access control rules.
	* This method is used by the 'accessControl' filter.
	* If RBAM is initialised the current user must be an RBAC Manager to 
	* reinitialise the RBAC system it.
	* If the RBAM is not initialised a logged in user can initialise it.
	* @return array access control rules
	*/
	public function accessRules() {
		$allow = ($this->_initialiser->getIsRBAMInitialised()?
			array('allow',
				'actions'=>array('initialise'),
				'roles'=>array($this->getModule()->rbacManagerRole),
			):
			array('allow',
				'actions'=>array('initialise'),
				'users'=>array('@'),
			)
		);
		return array(
			$allow,
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	/**
	* Initialise the controller 
	*/
	public function init() {
		$this->_initialiser = $this->getModule()->getComponent('initialiser');
	}
	
	/**
	* Initialise action.
	* Manages the RBAC initialisation.
	*/
	public function actionInitialise() {
		$this->pageTitle = Yii::t('RbamModule.initialisation','Initialise RBAC Authorisation Data');
		if (is_null($this->_initialiser)) // a direct http request to here and empty(RbamModule::initialise)
			$this->redirect(array('authItems/index'));

		$status=$this->_initialiser->canInitialise;
		if ($status===RbamInitialiser::STATUS_INITIALISE_RBAC)
			$status=$this->_initialiser->initialiseRBAC();
		elseif ($status===RbamInitialiser::STATUS_INITIALISE_RBAM)
			$status=$this->_initialiser->initialiseRBAM();
		
		if (is_string($status))
			$this->render('failure', compact('status'));
		elseif ($status===RbamInitialiser::STATUS_CONFIRM)
			$this->render('confirm');
		elseif ($status===RbamInitialiser::STATUS_RBAC_INITIALISED)
			$this->render('rbacInitialised');
		elseif ($status===RbamInitialiser::STATUS_RBAM_INITIALISED)
			$this->render('rbamInitialised');
	}
}
