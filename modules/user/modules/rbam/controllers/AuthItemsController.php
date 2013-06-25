<?php
/* SVN FILE: $Id: AuthItemsController.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* AuthItems Controller class file.
* Manages Auth Items.
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
/**
* AuthItems Controller class
* @package		RBAM
*/
class AuthItemsController extends RbamController {
	/**
	* Auth item types
	*/
	public $types = array(
		CAuthItem::TYPE_ROLE,
		CAuthItem::TYPE_TASK,
		CAuthItem::TYPE_OPERATION
	);
	
	/**
	* Messages passed to JavaScript.
	* Defined here to provide I18n.
	* @return array configuration
	*/
	public function config() {
		return array(
			'add'=>array(
				'url'=>$this->createUrl('addChild'),
				'title'=>Yii::t('RbamModule.rbam','Child Added'),
				'success'=>Yii::t('RbamModule.rbam','added as a child of'),
				'failure'=>Yii::t('RbamModule.rbam','not added as a child of'),
			),
			'remove'=>array(
				'url'=>$this->createUrl('removeChild'),
				'title'=>Yii::t('RbamModule.rbam','Child Removed'),
				'success'=>Yii::t('RbamModule.rbam','removed as a child of'),
				'failure'=>Yii::t('RbamModule.rbam','not removed as a child of'),
			),
			'error'=>array(
				'title'=>Yii::t('RbamModule.rbam','Error')
			),
		);
	}

	/**
	* @return array action filters
	*/
	public function filters() {
		return array(
			'accessControl', // perform access control for CRUD operations
			'ajaxOnly + addChild, removeChild' // Child items can only be added and removed via AJAX
		);
	}

	/**
	* Specifies the access control rules.
	* This method is used by the 'accessControl' filter.
	* @return array access control rules
	*/
	public function accessRules() {
		$module = $this->getModule();
		return array(
			array('allow',
				'actions'=>array(
					'index','create','manage','delete','addChild','removeChild'
				),
				'roles'=>array($module->authItemsManagerRole),
			),
			array('allow',
				'actions'=>array(
					'getChildren','getParents'
				),
				'roles'=>array(
					$module->authAssignmentsManagerRole,
					$module->authItemsManagerRole
				),
			),
			array('allow',
				'actions'=>array(
					'generate'
				),
				'roles'=>array($module->rbacManagerRole),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	/**
	* Returns the text version of the auth item type.
	* It can be "raw", or translated, and/or capitalised, and/or pluralised
	* @param integer the type of auth item
	* @param boolean whether to translate
	* @param boolean whether to capitalise
	* @param boolean whether to pluralise
	*/
	public function type($type, $t=false, $c=false, $p=false) {
		switch ($type) {
			case CAuthItem::TYPE_ROLE:
				if (!$t)
					return 'role';
				if ($c)
					return ($p?Yii::t('RbamModule.rbam', 'Roles'):Yii::t('RbamModule.rbam', 'Role'));
				return ($p?Yii::t('RbamModule.rbam', 'roles'):Yii::t('RbamModule.rbam', 'role'));
				break;
			case CAuthItem::TYPE_TASK:
				if (!$t)
					return 'task';
				if ($c)
					return ($p?Yii::t('RbamModule.rbam', 'Tasks'):Yii::t('RbamModule.rbam', 'Task'));
				return ($p?Yii::t('RbamModule.rbam', 'tasks'):Yii::t('RbamModule.rbam', 'task'));
				break;
			case CAuthItem::TYPE_OPERATION:
				if (!$t)
					return 'operation';
				if ($c)
					return ($p?Yii::t('RbamModule.rbam', 'Operations'):Yii::t('RbamModule.rbam', 'Operation'));
				return ($p?Yii::t('RbamModule.rbam', 'operations'):Yii::t('RbamModule.rbam', 'operation'));
				break;
		}
	}

	public function actionIndex($active=0) {
		$authItems = $this->_getAuthItems();
		$this->pageTitle = $this->_pageTitle($this->action->id);
		$this->breadcrumbs = array('RBAM'=>array('rbam/index'), $this->pageTitle);
		$this->render($this->action->id, compact('authItems', 'active'));
	}

	/**
	* Create a new auth item.
	*/
	public function actionCreate($type) {
		if (!array_key_exists($type, $this->types))
			throw new CHttpException(404, Yii::t('RbamModule.rbam','Invalid authorisation item type.'));

		$authItem = new AuthItem('create'); // $authItem is a CFormModel
		$authItem->setAttributes(compact('type'));
		$form = $authItem->getForm();
		if ($form->submitted($form->uniqueId)) {
			$response = array();
			if ($authItem->save()) {
				$response['content'] = Yii::t('RbamModule.rbam','"{item}" {type} created.', array(
					'{item}'=>$authItem->name,
					'{type}'=>$this->type($type, true)
				));
				$response['redirect'] = $this->createUrl('manage', array('item'=>$authItem->name));
			}
			else {
				$errors = array();
				foreach ($authItem->getErrors() as $attribute=>$attributeErrors)
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

		$this->pageTitle = $this->_pageTitle($this->action->id, array(
			'{type}'=>$this->type($type, true, true)
		));
		$this->breadcrumbs = array(
			'RBAM'=>array('rbam/index'),
			$this->_pageTitle('index')=>array('index'),
			$this->pageTitle
		);

		$this->render('form', compact('form', 'type'));
	}

	/**
	* Update an auth item.
	* Note: The item's type can not be changed.
	*/
	public function actionManage($item) {
		$item = $this->authManager->getEAuthItem($item);
		if (empty($item))
			throw new CHttpException(404, Yii::t('RbamModule.rbam','Authorisation item not found.'));
			
		$authItem = new AuthItem('update'); // $authItem is a CFormModel
		$attributes = array();
  	foreach ($authItem->getAttributes() as $name=>$value)
	  	$authItem->$name = $item->$name;
	  
		$form = $authItem->getForm(!in_array($item->name, $this->getModule()->getDefaultRoles()));
		if ($form->submitted($form->uniqueId)) {
			$response = array();
			if ($authItem->save($item)) {
				$response['content'] = Yii::t('RbamModule.rbam','"{item}" {type} updated.', array(
					'{item}'=>$item->name,
					'{type}'=>$this->type($item->type, true)
				));
				if ($item->name!==$_POST['AuthItem']['oldName'])
					$response['redirect'] = $this->createUrl($this->action->id, array('item'=>$item->name));
			}
			else {
				$errors = array();
				foreach ($authItem->getErrors() as $attribute=>$attributeErrors)
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
		
		if (Yii::app()->getUser()->checkAccess($this->getModule()->authAssignmentsManagerRole)) {
			$authAssignment = new AuthAssignment('upate'); // $authAssignment is a CFormModel
			$assignmentForm = $authAssignment->getForm();			
		}
		else
			$assignmentForm = null;

		$this->pageTitle = $this->_pageTitle($this->action->id, array(
			'{item}'=>$item->name,
			'{type}'=>$this->type($item->type, true, true)
		));
		$this->breadcrumbs = array(
			'RBAM'=>array('rbam/index'),
			$this->_pageTitle('index')=>array('index'),
			$this->pageTitle
		);

		$this->render('form', compact('item', 'form', 'assignmentForm'));
	}

	/**
	* Delete an auth item.
	* Ajax only action.
	*/
	public function actionDelete($item) {
		$authItem = $this->authManager->getAuthItem($item);
		$this->authManager->removeAuthItem($item);
    $this->authManager->save();
		$response = array();
	  $response['content'] = Yii::t('RbamModule.rbam','"{item}" deleted.', array(
	 		'{item}'=>$item,
	  ));
		header('Content-type: application/json');	  
		echo CJSON::encode($response);
	  Yii::app()->end();
	}

	/**
	* Adds a child item.
	* Ajax only action.
	*/
	public function actionAddChild($parent, $child) {		
    $parent = $this->authManager->getAuthItem($parent);
    $child = $this->authManager->getAuthItem($child);
    $this->authManager->addItemChild($parent->name, $child->name);
    $this->authManager->save();
		$response = array();
		$response['status'] = 1;
		$response['parent'] = array('name'=>$parent->name, 'type'=>$this->type($parent->type));
		$response['child'] = array('name'=>$child->name, 'type'=>$this->type($child->type));
    header('Content-type: application/json');
		echo CJSON::encode($response);
		Yii::app()->end();  
	}

	/**
	* Removes a child item.
	* Ajax only action.
	*/
	public function actionRemoveChild($parent, $child) {		
    $parent = $this->authManager->getAuthItem($parent);
    $child = $this->authManager->getAuthItem($child);
    $status = (int)$this->authManager->removeItemChild($parent->name, $child->name);
    $this->authManager->save();
		$response = array();
		$response['status'] = $status;
		$response['parent'] = array('name'=>$parent->name, 'type'=>$this->type($parent->type));
		$response['child'] = array('name'=>$child->name, 'type'=>$this->type($child->type));
    header('Content-type: application/json');
		echo CJSON::encode($response);
		Yii::app()->end();  
	}

	/**
	* Returns the children of an item.
	* Ajax only action.
	*/
	public function actionGetChildren($item) {
		$dataProvider = new CArrayDataProvider(
			array_values($this->authManager->getItemEChildren($item)),
			array('keyField'=>'name')
		); 
		echo $this->renderPartial('_relations', compact('dataProvider'));
		Yii::app()->end();
	}

	/**
	* Returns the parents of an item.
	* Ajax only action.
	*/
	public function actionGetParents($item) {
		$dataProvider = new CArrayDataProvider(
			array_values($this->authManager->getItemEParents($item)),
			array('keyField'=>'name')
		);
		$this->renderPartial('_relations', compact('dataProvider'));
		Yii::app()->end();
	}
	
	/**
	* Generates authorisation items based on modules, controllers and actions in
	* the application.
	*/
	public function actionGenerate() {
		if (!empty($_POST)) {
			$roles = $tasks = $operations = 0; // how many new items are generated
			$suffix = (!empty($_POST['suffix'])?"!{$_POST['suffix']}":'');
			
			foreach ($_POST['items'] as $index=>$item) {
				$item = str_replace(self::SPACE_IN_ID,' ',$item).$suffix;
				$type = $_POST['types'][$index];

				switch ($type) {
					case 'action':
						$operation = $this->authManager->getAuthItem($item);
						if (empty($operation)) {
							$operation = $this->authManager->createOperation($item);
							$operations++;
						}
							if (!$task->hasChild($item))
								$task->addChild($item);
						break;
					case 'controller':
						$task = $this->authManager->getAuthItem($item);
						if (empty($task)) {
							$task = $this->authManager->createTask($item);
							$tasks++;
						}
						if (!$role->hasChild($item))
							$role->addChild($item);
						break;
					case 'module':
						$role = $this->authManager->getAuthItem($item);
						if (empty($role)) {
							$role = $this->authManager->createRole($item);
							$roles++;
						}
						$pos = strpos($item,':');
						if ($pos===false)
							$parent = $root;
						else
							$parent = $this->authManager->getAuthItem(substr($item,0,$pos).$suffix);
						
						if (!$parent->hasChild($item))
							$parent->addChild($item);
						break;
					case 'root':
						$role = $this->authManager->getAuthItem($item);
						if (empty($role)) {
							$role = $this->authManager->createRole($item);
							$roles++;
						}
						$root = $role;
						break;
					default:
						break;
				}
			}
			$this->authManager->save(); // for CPhpAuthManager
			
			$response = array();
			if  ($roles===0 && $tasks===0 && $operations===0) {
				$response['status'] = 0;
				$response['content'] = Yii::t('RbamModule.rbam','No new authorisation data generated.');
			}
			else {
				$response['status'] = 1;
				$response['content'] = Yii::t('RbamModule.rbam','Generated {roles} roles, {tasks} tasks, and {operations} operations.', array(
					'{roles}'=>$roles,
					'{tasks}'=>$tasks,
					'{operations}'=>$operations
				));
			}
			header('Content-type: application/json');
			echo CJSON::encode($response);
	  	Yii::app()->end();
		}
		
		$analyser = $this->getModule()->getComponent('analyser');
		$root = $analyser->run();
		
		$data = array();
		$data[] = array(
			'data'=>$root->id,
			'attr'=>array('id'=>$this->toHtmlId($root->id),'rel'=>'root'),
			'children'=>array(
				(isset($root->controllers)?
					array(
						'data'=>'Controllers',
						'children'=>$this->_toTreeData($root->controllers, 'Controller')
					):array()),
				(isset($root->modules)?
					array(
						'data'=>'Modules',
						'children'=>$this->_toTreeData($root->modules, 'Module')
					):array())
			)
		);
		
		$authItems = $this->_getAuthItems();
		$this->pageTitle = $this->_pageTitle($this->action->id);
		$this->breadcrumbs = array(
			'RBAM'=>array('rbam/index'),
			$this->pageTitle
		);
		$this->render($this->action->id, compact('data', 'authItems'));
	}
	
	/**
	* Converts the data returned from the analyser component into a form suitable
	* for the tree widget
	* 
	* @param array the items to convert
	* @param string the type of items - modules, controllers, or actions
	* @param string path of parent item. Prefixed to item ids to create unique names.
	*/
	private function _toTreeData($items, $type, $path='') {
		$data = array();
		foreach ($items as $item) {
			$id = ($path?$path.':':'').$this->toHtmlId($item->id);
			$data[] = array(
				'data'=>"$item->id $type",
				'attr'=>array('id'=>$id,'rel'=>strtolower($type)),
				'children'=>(isset($item->modules) || isset($item->controllers)?
					array(
						(isset($item->controllers)?
							array(
								'data'=>'Controllers',
								'children'=>$this->_toTreeData($item->controllers, 'Controller', $id)
							):array()),
						(isset($item->modules)?
							array(
								'data'=>'Modules',
								'children'=>$this->_toTreeData($item->modules, 'Module', $id)
							):array()
						)
					):
					(isset($item->actions)?$this->_toTreeData($item->actions, 'Action', $id):array())
				),
			);
		}
		return $data;
	}
	
	/**
	* Converts a madule/controller/action id into an HTML id
	* @param string madule/controller/action id
	* @return string HTML id
	*/
	private function toHtmlId($id) {
		return strtr($id, array(' '=>self::SPACE_IN_ID,'/'=>'_'));
	}
	
	private function _getAuthItems() {
		Yii::import('rbam.extensions.alphapager.ApPagination');
		Yii::import('rbam.extensions.alphapager.ApArrayDataProvider');
		
		$authItems = array();
		$attribute = 'name';
		foreach ($this->types as $type) {
			$alphaPagination = new ApPagination($attribute);
			$data = array_values($this->authManager->getEAuthItems($type));
			$alphaPagination->activeCharSet = $this->activeChars($data, $attribute);
			$authItems[$type] = new ApArrayDataProvider($data,
				array(
					'keyField'=>$attribute,
					'alphapagination'=>$alphaPagination,
					'pagination'=>array(
						'pageSize'=>$this->getModule()->pageSize
					),
					'sort'=>array(
						'attributes'=>array('name', 'description'),
						'defaultOrder'=>array('name'=>false, 'description'=>false),
					)
				)
			);
		}
		return $authItems; 
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
				return Yii::t('RbamModule.rbam','Authorisation Items');
				break;
			case 'create':
				return Yii::t('RbamModule.rbam','Create {type}',$params);
				break;
			case 'manage':
				return Yii::t('RbamModule.rbam','Manage "{item}" {type}',$params);
				break;;
			case 'generate':
				return Yii::t('RbamModule.rbam','Generate Authorisation Data');
				break;
		}
	}
}
