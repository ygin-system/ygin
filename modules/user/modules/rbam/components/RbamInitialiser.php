<?php
/* SVN FILE: $Id: RbamInitialiser.php 28 2011-04-05 19:04:17Z Chris $*/
/**
* RBAM Initialiser class file.
* Initialises the RBAC system and/or RBAM.
*
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 28 $
* @license		BSD License (see documentation)
*/
/**
* RBAM Initialiser class
* @package		RBAM
*/
class RbamInitialiser extends CComponent {
	const STATUS_CONFIRM = 1;
	const STATUS_INITIALISE_RBAC = 2;
	const STATUS_INITIALISE_RBAM = 3;
	const STATUS_RBAC_INITIALISED = 4;
	const STATUS_RBAM_INITIALISED = 5;

	/**
	* @property array Roles initialised by default.
	*/
	public $defaultRoles;
	/**
	* @property mixed Defines the values RBAM should initialise the RBAC system.
	* WARNING: Initialising the RBAC system will clear existing authorisation
	* data (auth items, auth item children, and assignments).
	* String: the path to a file returns an array that defines the authorisation
	* data that RBAM will use to initialise the RBAC system. The array format is
	* that used by CPhpAuthManager, meaning that this option can be used to
	* import authorisation data if changing to CDbAuthManager; see below for the
	* array format.
	* Array: defines the authorisation data that RBAM will use to initialise the
	* RBAC system. The array format is that used by CPhpAuthManager; see below for
	* the array format.
	* Boolean: If === TRUE RBAM will initialise the RAC system with default auth
	* items and auth item children; the current user will be assigned the
	* "RBAC Manager" role.
	* If empty() (default) no initialisation is performed.
	*/
	public $initialise;

	private $_authManager;
	private $_defaultAuthData;
	private $_sql = array(
		'create tables'=>array( // Order of the tables is important because of foreign key constraints
			// Item Table
			"CREATE TABLE {itemTable} (
				name varchar(64) not null,
				type integer not null,
				description text,
				bizrule text,
				data text,
				primary key (name)
			)",
			// Item Child Table
			"CREATE TABLE {itemChildTable} (
				parent varchar(64) not null,
				child varchar(64) not null,
				primary key (parent, child),
				foreign key (parent) references {itemTable} (name) on delete cascade on update cascade,
				foreign key (child) references {itemTable} (name) on delete cascade on update cascade
			)",
			// Assignment Table
			"CREATE TABLE {assignmentTable} (
				itemname varchar(64) not null,
				userid varchar(64) not null,
				bizrule text,
				data text,
				primary key (itemname, userid),
				foreign key (itemname) references {itemTable} (name) on delete cascade on update cascade
			)"
		),
		'drop tables'=>"DROP TABLE IF EXISTS {table}"
	);

	/**
	* Initialises the component
	*/
	public function init() {
		$this->_authManager = Yii::app()->getAuthManager();
	}

	/**
	* Initialises RBAC authorisation data.
	* @return integer initialisation status
	*/
	public function initialiseRBAC() {
		if (empty($this->initialise))
			return Yii::t('RbamModule.initialisation', 'Cannot initialise; no authorisation data.');

		if (is_array($this->initialise))
			$items = $this->initialise;
		elseif (is_string($this->initialise))
			$items = $this->loadFromFile($this->initialise);
		else
			$items=array();

		// Make sure the default roles exist
		foreach ($this->defaultRoles as $index=>$role) {
			if (!array_key_exists($role, $items)) {
				$items[$role] = $this->defaultAuthData($index);
			}
		}

		if ($this->_authManager instanceof CDbAuthManager) {
			$status = $this->createAuthTables();
			if ($status !== true)
				return $status;
		}

		$this->_authManager->clearAll();
		$status = $this->initialise($items);
		return ($status===true?self::STATUS_RBAC_INITIALISED:$status);
	}

	/**
	* Initialises default roles
	* @return integer initialisation status
	*/
	public function initialiseRBAM() {
		$items=array();

		// Make sure the default roles exist
		foreach ($this->defaultRoles as $index=>$role)
			$items[$role] = $this->defaultAuthData($index);

		$status = $this->initialise($items);
		return ($status===true?self::STATUS_RBAM_INITIALISED:$status);
	}

	/**
	* Initialise RBAC with the items and assigns the current user to the RBAC
	* Manager role
	* @param array auth items
	* @return mixed boolean true if the auth data initialised successfully;
	* string error message if initialisatin failed.
	*/
	private function initialise($items) {
		try {
			foreach ($items as $name=>$item)
				if (is_null($this->_authManager->getAuthItem($name)))
					$this->_authManager->createAuthItem($name,$item['type'],$item['description'],$item['bizRule'],$item['data']);

			foreach ($items as $name=>$item) {
				if (isset($item['children']) && is_array($item['children'])) {
					foreach ($item['children'] as $childName) {
						if (empty($items[$childName]))
							throw new CException(Yii::t('RbamModule.initialisation', 'Cannot add "{child}" as a child of "{parent}". "{child}" does not exist', array('{child}'=>$childName, '{parent}'=>$name)));

						if ($items[$childName]['type']>$items[$name]['type'])
							throw new CException(Yii::t('RbamModule.initialisation', 'Cannot add "{child}" as a child of "{parent}". Incompatible types', array('{child}'=>$childName, '{parent}'=>$name)));

						if (!$this->_authManager->hasItemChild($name, $childName))
							$this->_authManager->addItemChild($name, $childName);
					}
				}
				if ($item['type']===CAuthItem::TYPE_ROLE && isset($item['assignments']) && is_array($item['assignments'])) {
					foreach ($item['assignments'] as $userId=>$assignment)
						$this->_authManager->assign($name,$userId,$assignment['bizRule'],$assignment['data']);
				}
			}

			// Make sure the current user is assigened the RBAC Manager role
			if (!$this->_authManager->getAuthAssignment($this->defaultRoles['RBAC Manager'], Yii::app()->user->id))
				$this->_authManager->assign($this->defaultRoles['RBAC Manager'], Yii::app()->user->id);

			$this->_authManager->save();  // for CPhpAuthManager
			return true;
		}
		catch (CException $e) {
			return $e->getMessage();
		}
	}

	/**
	* Returns a value indicating if the RBAC system can be initialised.
	* The RBAC system can be initialised if either there is no existing
	* authorisation data or the user has confirmed that they wish to
	* re-initialise.
	* @return integer
	* self::STATUS_INITIALISE_RBAC if the RBAC system can be initialised,
	* self::STATUS_CONFIRM if confirmation to initialise the RBAC systems is required
	*/
	public function getCanInitialise() {
		if (!$this->getIsRBACInitialised())
			$status = self::STATUS_INITIALISE_RBAC;
		elseif (isset($_POST['initialise']))
			 $status = intval($_POST['initialise']); // self::STATUS_INITIALISE_RBAC or self::STATUS_INITIALISE_RBAM
		else
			$status = self::STATUS_CONFIRM;
		return $status;
	}

	/**
	* Returns a value indicating if the RBAC system is initialised.
	* The RBAC system is considered to be initialised if there is existing
	* authorisation data.
	* @return boolean True if the RBAC system is initialised
	*/
	public function getIsRBACInitialised() {
		try {
			return (bool)count($this->_authManager->getAuthitems());
		}
		catch (CDbException $e) { // if CDbAuthManager and no tables exist
			return false;
		}
	}

	/**
	* Returns a value indicating if RBAM system is initialised.
	* RBAM system is considered to be initialised if all the required RBAM roles
	* exist.
	* @return boolean True if RBAM is initialised
	*/
	public function getIsRBAMInitialised() {
		try {
			return
				!is_null($this->_authManager->getAuthitem($this->defaultRoles['RBAC Manager'])) &&
				!is_null($this->_authManager->getAuthitem($this->defaultRoles['Auth Items Manager'])) &&
				!is_null($this->_authManager->getAuthitem($this->defaultRoles['Auth Assignments Manager']));
		}
		catch (CDbException $e) { // if CDbAuthManager and no tables exist
			return false;
		}
	}

	/**
	* Loads authorisation data from a file
	* @param string file to load
	* @return array authorisation data in the file
	*/
	private function loadFromFile($file) {
		if(is_file($file))
			return require($file);
		else
			return array();
	}

	/**
	* Creates RBAC database tables
	*/
	private function createAuthTables() {
		$dbTransaction = $this->_authManager->db->beginTransaction();
		try {
			$this->dropTables();

			foreach ($this->_sql['create tables'] as $sql)
				$this->_authManager->db->createCommand(
					str_replace('{assignmentTable}', $this->_authManager->assignmentTable,
						str_replace('{itemTable}', $this->_authManager->itemTable,
							str_replace('{itemChildTable}', $this->_authManager->itemChildTable, $sql)
						)
					)
				)->execute();

			$dbTransaction->commit();
			return true;
		}
		catch(CDbException $e) {
			$dbTransaction->rollback();
			return $e->getMessage();
		}
	}

	/**
	* Drops existing RBAC database tables
	*/
	private function dropTables() {
		foreach (array( // Order of the tables is important because of foreign key constraints
			$this->_authManager->assignmentTable,
			$this->_authManager->itemChildTable,
			$this->_authManager->itemTable
		) as $table)
			$this->_authManager->db->createCommand(
				str_replace('{table}',$table,$this->_sql['drop tables'])
			)->execute();
	}

	/**
	* Returns default authorisation data for the specified item
	* @param mixed $index
	*/
	private function defaultAuthData($index) {
		if (is_null($this->_defaultAuthData))
			$this->_defaultAuthData = array(
				$this->defaultRoles['Auth Items Manager']=>array(
					'type'=>CAuthItem::TYPE_ROLE,
					'description'=> Yii::t('RbamModule.initialisation','Manages Auth Items. RBAM required role.'),
					'bizRule'=>null,
					'data'=>null,
				),
				$this->defaultRoles['Auth Assignments Manager']=>array(
					'type'=>CAuthItem::TYPE_ROLE,
					'description'=> Yii::t('RbamModule.initialisation','Manages Role Assignments. RBAM required role.'),
					'bizRule'=>null,
					'data'=>null,
				),
				$this->defaultRoles['RBAC Manager']=>array(
					'type'=>CAuthItem::TYPE_ROLE,
					'description'=>Yii::t('RbamModule.initialisation','Manages Auth Items and Role Assignments. RBAM required role.'),
					'bizRule'=>null,
					'data'=>null,
					'children'=>array(
						$this->defaultRoles['Auth Items Manager'],
						$this->defaultRoles['Auth Assignments Manager']
					),
				),
				$this->defaultRoles['Authenticated']=>array(
					'type'=>CAuthItem::TYPE_ROLE,
					'description'=> Yii::t('RbamModule.initialisation','Default role for users that are logged in. RBAC default role.'),
					'bizRule'=>'return !Yii::app()->getUser()->getIsGuest();',
					'data'=>null,
				),
				$this->defaultRoles['Guest']=>array(
					'type'=>CAuthItem::TYPE_ROLE,
					'description'=> Yii::t('RbamModule.initialisation','Default role for users that are not logged in. RBAC default role.'),
					'bizRule'=>'return Yii::app()->getUser()->getIsGuest();',
					'data'=>null,
				),
			);
		return $this->_defaultAuthData[$this->defaultRoles[$index]];
	}
}
