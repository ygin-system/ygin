<?php
/* SVN FILE: $Id: RbamController.php 19 2011-02-17 15:12:45Z Chris $*/
/**
* RBAM Controller class file.
* Base Controller for all RBAM controllers.
*
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 19 $
* @license		BSD License (see documentation)
*/
/**
* RBAM Controller class
* @package		RBAM
*/
class RbamController extends Controller {
	const SPACE_IN_ID = '-_-';
	const GRID_SELECT_NONE = 0;
	const GRID_SELECT_ONE = 1;
	const GRID_SELECT_MANY = 2;

	/**
	* @property array support for zii breadcrumbs widget
	*/
	public $breadcrumbs;
	/**
	* @var array support for metadata extension
	*/

	/**
	* @property CAuthManager The auth manager component
	*/
	public $authManager;

	/**
	* @return array action filters
	*/
	public function filters() {
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	* Specifies the access control rules.
	* This method is used by the 'accessControl' filter.
	* @return array access control rules
	*/
	public function accessRules() {
		$module = $this->getModule();
		if ($this->authManager->getAuthItem($module->rbacManagerRole))
			$allow = array('allow',
				'actions'=>array(
					'index'
				),
				'roles'=>array(
					$module->authAssignmentsManagerRole,
					$module->authItemsManagerRole
				),
			);
		else
			$allow = array('allow',
				'actions'=>array(
					'index'
				),
				'users'=>array('@'),
			);
		return array(
			$allow,
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	* RBAM home page action
	*/
	public function actionIndex() {
		$this->pageTitle = 'Role Based Access Manager';
		$this->breadcrumbs = array($this->pageTitle);
		$this->render($this->action->id);
	}

	/**
	* Returns an array of initial characters from the source.
	* Source can be a CActiveRecord, or an array of data or data objects.
	* By default, characters are returned in uppercase; set preserveCase true to
	* return characters in their original case.
	* Used in ApPagination
	* @param mixed string: table name; array: the data or data objects
	* @param string Attribute name. The attribute can be a relative attribute if
	* source is a, or an array of, CActiveRecord; e.g. relation.attribute.
	* If empty, source must be an array; the values of which are used.
	*/
	public function activeChars($source, $attribute='', $preserveCase=false) {
		if (is_array($source)) {
			$chars = array();
			if ($attribute) {
				if ($preserveCase)
					foreach ($source as $datum)
						$chars[] = substr(CHtml::value($datum, $attribute),0,1);
				else
					foreach ($source as $datum)
						$chars[] = strtoupper(substr(CHtml::value($datum, $attribute),0,1));
			}
			else {
				if ($preserveCase)
					foreach ($source as $datum)
						$chars[] = substr($datum,0,1);
				else
					foreach ($source as $datum)
						$chars[] = strtoupper(substr($datum,0,1));
			}
			return array_unique($chars);
		}
		elseif ($source instanceof CActiveRecord) {
			if (empty($attribute))
				throw new CException(UsersModule::t('core', 'Attribute cannot be empty when using a model'));

			$connection = $source->getDbConnection();
			if (($pos = strpos($attribute, '.'))!==false) {
				$name = substr($attribute, 0, $pos);
				$md = $source->getMetaData();
				if (!isset($md->relations[$name]))
					throw new CDbException(Yii::t('yii','{class} does not have relation "{name}".',
						array('{class}'=>get_class($this), '{name}'=>$name)));
				$source = CActiveRecord::model($md->relations[$name]->className);
				$attribute = substr($attribute, $pos+1);
			}
			$sql = $preserveCase?
				'SELECT DISTINCT(SUBSTR('.$connection->quoteColumnName($attribute).',1,1)) AS '.$connection->quoteColumnName('c').' FROM '.$connection->quoteTableName($source->tableName()):
				'SELECT DISTINCT(UPPER(SUBSTR('.$connection->quoteColumnName($attribute).',1,1))) AS '.$connection->quoteColumnName('c').' FROM '.$connection->quoteTableName($source->tableName());
			return Yii::app()->db->createCommand($sql)->queryColumn();
		}
	}
}
