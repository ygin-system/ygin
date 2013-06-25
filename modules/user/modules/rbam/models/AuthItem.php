<?php
/* SVN FILE: $Id: AuthItem.php 17 2010-12-21 19:09:15Z Chris $*/
/**
* AuthItem Model class file.
* Provides the form and model for auth assignments
*
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 17 $
* @license		BSD License (see documentation)
*/
/**
* AuthItem Model class
* @package		RBAM
*/
class AuthItem extends RBAMBaseModel {
	/**
	* @property string the authorisation item name
	*/
	public $name;
	/**
	* @property integer the authorisation item type.
	*/
	public $type;
	/**
	* @property string the item description
	*/
	public $description;
	/**
	* @property string the business rule associated with this item
	*/
	public $bizrule;
	/**
	* @property mixed additional data associated with this item
	*/
	public $data;
	private $oldName;
	private $authManager;

	/**
	* @return array customized attribute labels (name=>label)
	*/
	public function attributeLabels() {
		return array(
			'name'=>Yii::t('RbamModule.rbam','Name'),
			'description'=>Yii::t('RbamModule.rbam','Description'),
			'bizrule'=>Yii::t('RbamModule.rbam','Business Rule'),
			'data'=>Yii::t('RbamModule.rbam','Data'),
		);
	}

	/**
	* @return array validation rules for model attributes.
	*/
	public function rules() {
		return array(
			array('name, description', 'required'),
			array('name', 'length', 'max'=>64),
			array('name', 'unique'),
			array('bizrule', 'match', 'pattern'=>'/^return .+?;$/i'),
			array('bizrule', 'rbam.validators.BizRuleValidator'),
			array('data', 'rbam.validators.DataValidator'),
			array('description, bizrule, data', 'length', 'max'=>65536),
			array('type, oldName', 'safe')
		);
	}

	/**
	* Sets the old name of the item
	* @param string the old name of the item
	*/
	public function setOldName($oldName) {
		$this->oldName = $oldName;
	}

	/**
	* Saves the item.
	* If it is a new item an item is created. If it is an existing item it is
	* updated.
	* @param CAuthItem the item to save. If null a new item is created.
	* @return boolean true if the item was saved, false if not
 	*/
	public function save($item=null) {
		$this->authManager = Yii::app()->getAuthManager();
		if ($this->validate() && $this->beforeSave()) {
			if (is_null($item)) {
				$this->authManager->createAuthItem(
					$this->name,
					$this->type,
					$this->description,
					empty($this->bizrule)?null:$this->bizrule,
					empty($this->data)?null:$this->data
				);
			}
			else {
				$oldName = (
					$this->name===$item->name || $this->authManager instanceof CPhpAuthManager
					?null:$item->name
				);
				foreach ($this->getAttributes() as $name=>$value)
					if ($name!=='type')
						$item->$name = $value;
				$this->authManager->saveAuthItem($item, $oldName);
			}
			$this->authManager->save(); // for CPhpAuthmanager
			$this->afterSave();
			return true;
		}
		else
			return false;
	}

	/**
	* Get the form
	* @param boolean Whether the item can be renamed. If not the name element is
	* made read only.
	* @return CForm Form for the model
	*/
	public function getForm($rename=true) {
		$form = new CForm($this->_formConfig(), $this);

		$elements = $form->getElements();
		if (!$rename)
			$elements['name']->attributes = array('readonly'=>'readonly');

		if ($this->scenario==='update')
			$elements->add('oldName', array(
				'type'=>'hidden',
				'value'=>$this->name,
				'visible'=>true
			));

		return $form;
	}

	/**
	* Validator to determine if the name is unique among auth items.
	* @param string attribute to test; this should be name
	* @param mixed additional parameters
	* @see rules()
	*/
	public function unique($attribute, $params) {
	  if (($this->scenario==='create' || $this->name!==$this->oldName)
	  		&& !is_null($this->authManager->getAuthItem($this->name)))
			$this->addError('name', Yii::t('RbamModule.validation','The name "{name}" is already used by another item.',array('{name}'=>$this->name)));
	}

	/**
	* Form definition.
	*/
	private function _formConfig() {
		return array(
			'elements'=>array(
				'name'=>array(
					'type'=>'text',
					'hint'=>Yii::t('RbamModule.rbam','Uniquely identifies the item.')
				),
				'type'=>array(
					'type'=>'hidden'
				),
				'description'=>array(
					'type'=>'textarea',
					'rows'=>3,
					'hint'=>Yii::t('RbamModule.rbam','Description of the item.')
				),
				'bizrule'=>array(
					'type'=>'textarea',
					'rows'=>3,
					'hint'=>Yii::t('RbamModule.rbam','A piece of PHP code that is executed when checking access permission for this item.').'<br />'.Yii::t('RbamModule.rbam','The Business Rule can refer to two variables: <em>$params</em> - passed from the application, and <em>$data</em> - specified below.<br />Return <strong>true</strong> to grant permission.')
				),
				'data'=>array(
					'type'=>'textarea',
					'rows'=>3,
					'hint'=>Yii::t('RbamModule.rbam','Additional data associated with this item; passed as the variable <em>$data</em> to the Business Rule.')
				)
			),
			'buttons'=>array(
				'submit'=>array(
					'type'=>'submit',
					'label'=>Yii::t('RbamModule.rbam',ucfirst($this->scenario))
				)
			)
		);
	}
}
