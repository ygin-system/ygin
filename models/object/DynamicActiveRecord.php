<?php
/**
 * CActiveRecord implementation that allows specifying
 * DB table name instead of creating a class for each table.
 * 
 * Usage (assuming table 'user' with columns 'id' and 'name'):
 * 
 * 	$userModel = DynamicActiveRecord::forTable('user');
 * 	//list existing users
 * 	foreach ($userModel->findAll() as $user)
 * 		echo $user->id . ': ' . $user->name . '<br>';
 * 	//add new user
 * 	$userModel->name = 'Pavle Predic';
 * 	$userModel->save();
 * 
 * @author Pavle Predic <https://github.com/pavlepredic>
 */
class DynamicActiveRecord extends DaActiveRecord
{
	/**
	 * Name of the DB table
	 * @var string
	 */
	protected $_tableName;

	/**
	 * Table meta-data.
	 * Must redeclare, as parent::_md is private
	 * @var CActiveRecordMetaData
	 */
	protected $_md;

	/**
	 * Constructor
	 * @param string $scenario (defaults to 'insert')
	 * @param string $tableName
	 */
	public function __construct($scenario = 'insert', $tableName = null)
	{
		$this->_tableName = $tableName;
		parent::__construct($scenario);
	}

	/**
	 * Overrides default instantiation logic.
	 * Instantiates AR class by providing table name
	 * @see CActiveRecord::instantiate()
	 * @return DynamicActiveRecord
	 */
	protected function instantiate($attributes) {
      $class=get_class($this);
      return new $class(null, $this->tableName());
	}

	/**
	 * Returns meta-data for this DB table
	 * @see CActiveRecord::getMetaData()
	 * @return CActiveRecordMetaData
	 */
	public function getMetaData()
	{
		if ($this->_md !== null)
			return $this->_md;
		else
			return $this->_md = new CActiveRecordMetaData($this);
	}

	/**
	 * Returns table name
	 * @see CActiveRecord::tableName()
	 * @return string
	 */
	public function tableName()
	{
		if (!$this->_tableName)
			$this->_tableName = parent::tableName();
		return $this->_tableName;
	}

	/**
	 * Returns an instance of DynamicActiveRecord for the provided DB table.
	 * This is a helper method that may be used instead of constructor.
	 * @param string $tableName
	 * @param string $scenario
	 * @return DynamicActiveRecord
	 */
	public static function forTable($tableName, $scenario = 'insert')
	{
		return new DynamicActiveRecord($scenario, $tableName);
	}
}