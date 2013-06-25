<?php
/* SVN FILE: $Id: AuthAssignmentsController.php 19 2011-02-17 15:12:45Z Chris $*/
/**
* AuthAssignments Controller class file.
* Manages Auth Assignments.
*
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 19 $
* @license		BSD License (see documentation)
*/
/**
* AuthAssignments Controller class
* @package		RBAM
*/
class AuthAssignmentsController extends RbamController {
	private $_user;

	/**
	* @return array action filters
	*/
	public function filters() {
		return array(
			'accessControl', // perform access control for CRUD operations
			'ajaxOnly + revoke, update', // Assignments can only be revoked and updated via AJAX
		);
	}

	/**
	* Specifies the access control rules.
	* This method is used by the 'accessControl' filter.
	* @return array access control rules
	*/
	public function accessRules() {
		return array(
			array('allow',
				'actions'=>array(
					'index','assign','revoke','update','roleUsers','userRoles'
				),
				'roles'=>array($this->getModule()->authAssignmentsManagerRole),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	* Lists assignments.
	*/
	public function actionIndex() {
		Yii::import('rbam.extensions.alphapager.ApPagination');
		Yii::import('rbam.extensions.alphapager.ApActiveDataProvider');

		$module = $this->getModule();
		$userModel = CActiveRecord::model($module->userClass);
		$userNameAttribute = $module->userNameAttribute;

		if (is_string($userNameAttribute) && strpos($userNameAttribute, ',')!==false)
			$userNameAttribute = explode(',', str_replace('\,','__##comma##__',$userNameAttribute));

		if (is_array($userNameAttribute)) {
			array_shift($userNameAttribute);
			$end = end($userNameAttribute);
			if (is_array($end) || strpos($end, '__##comma##__')!==false || strpos($end, ',')!==false)
				array_pop($userNameAttribute);
		}
		else
			$userNameAttribute = array($userNameAttribute);

		$asc = join(',',$userNameAttribute);
		$desc = str_replace(',',' DESC,',$asc).' DESC';

		$attribute = array_shift($userNameAttribute);
		$alphaPagination = new ApPagination($attribute);
		$alphaPagination->forceCaseInsensitive  = true;
		$alphaPagination->activeCharSet = $this->activeChars($userModel, $attribute);

		$relation = ((($pos = strpos($attribute, '.'))===false)?null:substr($attribute, 0, $pos));
		$_criteria = $module->userCriteria;
		if (!empty($relation))
			$_criteria['with'][] = $relation;
		$criteria = new CDbCriteria($_criteria);

		$dataProvider = new ApActiveDataProvider($userModel, array(
			'criteria'=>$criteria,
			'alphapagination'=>$alphaPagination,
			'pagination'=>array(
	    	'pageSize'=>$module->pageSize,
	    ),
	    'sort'=>array(
	    	'attributes'=>array(
					'rbamName'=>array(
					  'asc'=>$asc,
					  'desc'=>$desc,
					  'default'=>'desc',
					),
				),
				'defaultOrder'=>array('rbamName'=>false)
			),
		));

		foreach ($dataProvider->getData() as $model)
			$model->attachBehavior('rbamUser', 'RbamUserBehavior');

		$this->pageTitle = $this->_pageTitle($this->action->id);
		$this->breadcrumbs = array('RBAM'=>array('rbam/index'), $this->pageTitle);
		$this->render($this->action->id, compact('dataProvider'));
	}

	/**
	* Assigns a role to a user.
	* This action handles the original assignment and the setting of a business
	* rule and data for the assignment.
	*/
	public function actionAssign($uid) {
		Yii::import('rbam.extensions.alphapager.ApPagination');
		Yii::import('rbam.extensions.alphapager.ApArrayDataProvider');

		$user = $this->_getUser($uid);
		$authAssignment = new AuthAssignment('assign'); // $authAssignment is a CFormModel
		$form = $authAssignment->getForm();
		if ($form->submitted($form->uniqueId)) { // there is no submit button from the juiDialog, so use the form id
			$response = array();
			if ($authAssignment->save()) {
	  		$response['content'] = Yii::t('RbamModule.rbam','"{role}" assigned to "{user}".',array(
	  			'{role}'=>$authAssignment->itemName,
	  			'{user}'=>$user->rbamName
	  		));
	  	}
			else {
				$errors = array();
				foreach ($authAssignment->getErrors() as $attribute=>$attributeErrors)
					foreach ($attributeErrors as $error)
						$errors[] = array(
							'attribute'=>$attribute,
							'label'=>$authItem->getAttributeLabel($attribute),
							'error'=>$error
						);
				$response = compact('errors');
			}
			header('Content-type: application/json');
			echo CJSON::encode($response);
	  	Yii::app()->end();
		}

		$attribute = 'name';
		$alphaPagination = new ApPagination($attribute);
		$data = array_values($this->authManager->getEUnassignedRoles($uid));
		$alphaPagination->activeCharSet = $this->activeChars($data, $attribute);
		$dataProvider = new ApArrayDataProvider($data,
			array(
				'keyField'=>$attribute,
				'alphapagination'=>$alphaPagination,
				'pagination'=>array(
					'pageSize'=>$this->module->pageSize
				),
				'sort'=>array(
					'attributes'=>array('name', 'description'),
					'defaultOrder'=>array('name'=>false, 'description'=>false),
				)
			)
		);

		$this->pageTitle = $this->_pageTitle($this->action->id, array('{user}'=>$user->rbamName));
		$this->breadcrumbs = array(
			'RBAM'=>array('rbam/index'),
			$this->_pageTitle('index')=>array('index'),
			$this->_pageTitle('userRoles', array(
				'{user}'=>$user->rbamName
					))=>array('userRoles', 'uid'=>$uid),
			$this->pageTitle
		);
		$this->render($this->action->id, compact('dataProvider','user','form'));
	}

	/**
	* Revokes a user::role assignment
	* Ajax only method
	*/
	public function actionRevoke($role, $uid) {
		$user = $this->_getUser($uid);
		$assignment = $this->authManager->getAuthAssignment($role, $uid);
		if (is_null($assignment))
			throw new CHttpException(404, Yii::t('RbamModule.rbam','"{user}::{role}" assignment not found.', array('{user}'=>$user->rbamName, '{role}'=>$role)));

		$this->authManager->revoke($role, $uid);
    $this->authManager->save();

		$response = array();
	  $response['content'] = Yii::t('RbamModule.rbam','"{user}::{role}" assignment revoked.', array(
	  	'{user}'=>$user->rbamName,
	  	'{role}'=>$role
	  ));
		header('Content-type: application/json');
		echo CJSON::encode($response);
	  Yii::app()->end();
	}

	/**
	* Roles assigned to a user
	*/
	public function actionUserRoles($uid) {
		Yii::import('rbam.extensions.alphapager.ApPagination');
		Yii::import('rbam.extensions.alphapager.ApArrayDataProvider');

		$authAssignment = new AuthAssignment(); // $authAssignment is a CFormModel
		$form = $authAssignment->getForm();

		$user = $this->_getUser($uid);
		$attribute = 'itemName';
		$alphaPagination = new ApPagination($attribute);
		$data = array_values($this->authManager->getEAuthAssignments($uid));
		$alphaPagination->activeCharSet = $this->activeChars($data, $attribute);
		$dataProvider = new ApArrayDataProvider($data,
			array(
				'keyField'=>$attribute,
				'alphapagination'=>$alphaPagination,
				'pagination'=>array(
					'pageSize'=>$this->module->pageSize
				),
				'sort'=>array(
					'attributes'=>array('itemName', 'itemDescription'),
					'defaultOrder'=>array('itemName'=>false, 'itemDescription'=>false),
				)
			)
		);

		$this->pageTitle = $this->_pageTitle($this->action->id, array(
			'{user}'=>$user->rbamName
		));
		$this->breadcrumbs = array(
			'RBAM'=>array('rbam/index'),
			$this->_pageTitle('index')=>array('index'),
			$this->pageTitle
		);
		$this->render($this->action->id, compact('user', 'dataProvider', 'form'));
	}

	/**
	* Users assigned to a role
	*/
	public function actionRoleUsers($role) {
		Yii::import('rbam.extensions.alphapager.ApPagination');
		Yii::import('rbam.extensions.alphapager.ApArrayDataProvider');

		$authAssignment = new AuthAssignment(); // $authAssignment is a CFormModel
		$form = $authAssignment->getForm();

		$attribute = 'username';
		$alphaPagination = new ApPagination($attribute);
		$data = array_values($this->authManager->getItemEAuthAssignments($role));
		$alphaPagination->activeCharSet = $this->activeChars($data, $attribute);
		$dataProvider = new ApArrayDataProvider($data,
			array(
				'keyField'=>'userId',
				'alphapagination'=>$alphaPagination,
				'pagination'=>array(
					'pageSize'=>$this->module->pageSize
				),
			)
		);

		$this->pageTitle = $this->_pageTitle($this->action->id, array(
			'{role}'=>$role
		));
		$this->breadcrumbs = array(
			'RBAM'=>array('rbam/index'),
			$this->_pageTitle('index')=>array('index'),
			$this->pageTitle
		);
		$this->render($this->action->id, compact('role', 'dataProvider', 'form'));
	}

	/**
	* Update a user::role assignment.
	* The only attributes that can be changed are bizrule and data.
	* Ajax only method
	*/
	public function actionUpdate() {
		$authAssignment = new AuthAssignment('upate'); // $authAssignment is a CFormModel
		$form = $authAssignment->getForm();
		if ($form->submitted($form->uniqueId)) { // there is no submit button from the juiDialog, so use the form id
			$response = array();
			if ($authAssignment->save()) {
	  		$response['content'] = Yii::t('RbamModule.rbam','"{user}::{role}" assignment updated.',array(
	  			'{role}'=>$authAssignment->itemName,
	  			'{user}'=>$authAssignment->userName
	  		));
	  	}
			else {
				$errors = array();
				foreach ($authAssignment->getErrors() as $attribute=>$attributeErrors)
					foreach ($attributeErrors as $error)
						$errors[] = array(
							'attribute'=>$attribute,
							'label'=>$authAssignment->getAttributeLabel($attribute),
							'error'=>$error
						);
				$response = compact('errors');
			}
			header('Content-type: application/json');
			echo CJSON::encode($response);
	  	Yii::app()->end();
		}
	}

	/**
	* Returns the page title for the given action.
	* Used to create breadcrumbs and dynamic page titles.
	* @param string action id
	* @param array parameters to be applied to the page title using <code>strtr</code>.
	* @return the paget title
	*/
	private function _pageTitle($id,$params=array()) {
		switch ($id) {
			case 'index':
				return Yii::t('RbamModule.rbam','Users');
				break;
			case 'assign':
				return Yii::t('RbamModule.rbam','Assign Role(s) to "{user}"',$params);
				break;
			case 'userRoles':
				return Yii::t('RbamModule.rbam','Roles Assigned to "{user}"',$params);
				break;
			case 'roleUsers':
				return Yii::t('RbamModule.rbam','Users Assigned to the "{role}" Role',$params);
				break;
		}
	}

	private function _getUser($id) {
		if (is_null($this->_user))
			$this->_user = $this->getModule()->getUser($id);
		return $this->_user;
	}
}