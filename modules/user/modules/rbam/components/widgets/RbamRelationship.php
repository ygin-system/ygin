<?php
/* SVN FILE: $Id: RbamRelationship.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* RBAM Relationships widget class file.
* Displays auth items with the specified relationship to the specified item.
*
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
/**
* RBAM Relationships widget class
* @package		RBAM
*/
Yii::import('zii.widgets.CPortlet');

class RbamRelationship extends CPortlet {
	/**
	* @property CAuthItem the item who's relations are being displayed.
	*/
	public $item;
	/**
	* @property string the relationship the items displayed in this have to the item.
	* Valid values are 'parents', 'children', or 'unrelated'.
	*/
	public $relationship;

	/**
	* @var array the related auth items by auth item type for the relationship
	*/
	private $_relations=array();

	/**
	* Initializes the widget.
	* This method will publish JUI assets if necessary.
	* It will also register jquery and JUI JavaScript files and the theme CSS file.
	* If you override this method, make sure you call the parent implementation first.
	*/
	public function init() {
		Yii::import('rbam.extensions.alphapager.ApPagination');
		Yii::import('rbam.extensions.alphapager.ApArrayDataProvider');

		$owner = $this->getOwner();
		$this->id = $this->relationship;
		$this->title = CHtml::tag('p', array(),
			$this->hint($this->relationship)).$this->relationship($this->relationship);
		$attribute = 'name';
		foreach ($owner->types as $type) {
			if (($this->relationship==='parents' && $type<$this->item->type) ||
					($this->relationship==='children' && $type>$this->item->type)
			)
				continue;
			$getter = 'getE'.ucfirst($this->relationship);

			$alphaPagination = new ApPagination($attribute);
			$data = array_values($this->item->$getter($type));
			$alphaPagination->activeCharSet = $owner->activeChars($data, $attribute);
			$this->_relations[$type] = new ApArrayDataProvider($data,
				array(
					'keyField'=>$attribute,
					'alphapagination'=>$alphaPagination,
					'pagination'=>array(
						'pageSize'=>(is_null($owner->module->relationshipsPageSize)
								?$owner->module->pageSize
								:$owner->module->relationshipsPageSize
						)
					),
					'sort'=>array(
						'attributes'=>array('name', 'description'),
						'defaultOrder'=>array('name'=>false, 'description'=>false),
					)
				)
			);
		}

		parent::init();
	}

	/**
	* Renders the widget
	*/
	protected function renderContent() {
		$owner = $this->getOwner();
		$tabs = array();
		foreach($this->_relations as $type=>$dataProvider) {
			$tabs[$this->relationship.'-'.$owner->type($type)] = array(
				'title'=>$owner->type($type, true, true, true).
					" (<span>{$dataProvider->totalItemCount}</span>)",
				'content'=>$this->render('RbamRelationship', compact('owner', 'dataProvider', 'type'), true)
			);
		}

		$owner->widget('system.web.widgets.CTabView', array('tabs'=>$tabs));
	}

	/**
	* Returns the hint for the specified relationship
	*/
	private function hint($rleationship) {
		switch ($rleationship) {
			case 'parents':
				return Yii::t('RbamModule.rbam', 'Drag unrelated items here to make them parents of {item}', array('{item}'=>$this->item->name));
				break;
			case 'children':
				return Yii::t('RbamModule.rbam', 'Drag unrelated items here to make them children of {item}', array('{item}'=>$this->item->name));
				break;
			case 'unrelated':
				return Yii::t('RbamModule.rbam', 'Drag parent or child items here to remove their relationship with {item}', array('{item}'=>$this->item->name));
				break;
		}
	}

	/**
	* Returns the translated relationship
	*/
	private function relationship($relationship) {
		switch ($relationship) {
			case 'parents':
				return Yii::t('RbamModule.rbam', 'Parents');
				break;
			case 'children':
				return Yii::t('RbamModule.rbam', 'Children');
				break;
			case 'unrelated':
				return Yii::t('RbamModule.rbam', 'Unrelated');
				break;
		}
	}
}
