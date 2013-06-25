<?php
/* SVN FILE: $Id: AuthAssignment.php 17 2010-12-21 19:09:15Z Chris $*/
/**
* AuthAssignment Model class file.
* Provides the form and model for auth assignments
*
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 17 $
* @license		BSD License (see documentation)
*/
/**
* AuthAssignment Model class
* @package		RBAM
*/
class AuthAssignment extends RBAMBaseModel {
	/**
	* @property string the authorisation item name
	*/
	public $itemName;
	/**
	* @property string the user name
	*/
	public $userName;
	/**
	* @property mixed user ID
	*/
	public $userId;
	/**
	* @property string the business rule associated with this assignment
	*/
	public $bizrule;
	/**
	* @property mixed additional data for this assignment
	*/
	public $data;

	/**
	* @return array customized attribute labels (name=>label)
	*/
	public function attributeLabels() {
		return array(
			'itemName'=>Yii::t('RbamModule.rbam','Role'),
			'userName'=>Yii::t('RbamModule.rbam','User'),
			'bizrule' =>Yii::t('RbamModule.rbam','Business Rule'),
			'data' =>Yii::t('RbamModule.rbam','Data'),
		);
	}

	/**
	* @return array validation rules for model attributes.
	*/
	public function rules() {
		return array(
			array('bizrule', 'match', 'pattern'=>'/^return .+?;$/i'),
			array('bizrule', 'rbam.validators.BizRuleValidator'),
			array('data', 'rbam.validators.DataValidator'),
			array('bizrule, data', 'length', 'max'=>65535),
			array('itemName, userId, userName', 'safe')
		);
	}

	/**
	* Saves the assignment.
	* If the scenario is "assign" an new assignment is created. If it is "update"
	* the assignment is updated.
	* @return boolean true if the assignment was saved, false if not
 	*/
	public function save() {
		if ($this->validate() && $this->beforeSave()) {
			$authManager = Yii::app()->getAuthManager();
			if ($this->scenario==='assign') {
				$authManager->assign(
					$this->itemName,
					$this->userId,
					empty($this->bizrule)?null:$this->bizrule,
					empty($this->data)?null:$this->data
				);
			}
			else { // it's update
				$assignment = $authManager->getAuthAssignment($this->itemName, $this->userId);
				$assignment->bizrule = empty($this->bizrule)?null:$this->bizrule;
				$assignment->data = empty($this->data)?null:$this->data;
				$authManager->saveAuthAssignment($assignment);
			}
			$authManager->save(); // for CPhpAuthmanager
			$this->afterSave();
			return true;
		}
		else
			return false;
	}

	/**
	* Get the form
	* @return CForm Form for the model
	*/
	public function getForm() {
		return new CForm($this->_formConfig(), $this);
	}

	/**
	* Form definition.
	*/
	private function _formConfig() {
		return array(
			'elements'=>array(
				'userName'=>array(
					'type'=>'text',
					'attributes'=>array('readonly'=>'readonly')
				),
				'itemName'=>array(
					'type'=>'text',
					'attributes'=>array('readonly'=>'readonly')
				),
				'userId'=>array(
					'type'=>'hidden'
				),
				'bizrule'=>array(
					'type'=>'textarea',
					'rows'=>3,
					'hint'=>Yii::t('RbamModule.rbam','A piece of PHP code that is executed when checking access permission for this assignment.').'<br />'.Yii::t('RbamModule.rbam','The Business Rule can refer to two variables: <em>$params</em> - passed from the application, and <em>$data</em> - specified below.<br />Return <strong>true</strong> to grant permission.')
				),
				'data'=>array(
					'type'=>'textarea',
					'rows'=>3,
					'hint'=>Yii::t('RbamModule.rbam','Additional data associated with this item; passed as the variable <em>$data</em> to the Business Rule.')
				)
			)
		);
	}
}
