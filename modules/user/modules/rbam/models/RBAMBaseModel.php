<?php
/* SVN FILE: $Id: RBAMBaseModel.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* RBAM Base Model class file.
* Base model for RBAM models. Provides events
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
/**
* RBAM Base Model class
* @package		RBAM
*/
class RBAMBaseModel extends CFormModel {
	/**
	 * This method is invoked after saving an auth item or assignment and raises
	 * the {@link onAfterSave} event.
	 */
	protected function afterSave() {
		$this->onAfterSave(new CEvent($this));
	}

	/**
	 * This method is invoked before saving an auth item or assignment,
	 * (after validation) and raises the {@link onBeforeSave} event.
	 * @return boolean whether the saving should be executed.
	 */
	protected function beforeSave() {
		$event=new CModelEvent($this);
		$this->onBeforeSave($event);
		return $event->isValid;
	}

	/**
	 * This event is raised before an auth item or assignment is saved.
	 * By setting {@link CModelEvent::isValid} to be false, the normal save()
	 * process will be stopped.
	 * @param CModelEvent $event the event parameter
	 */
	public function onBeforeSave($event) {
		$this->raiseEvent('onBeforeSave',$event);
	}

	/**
	 * This event is raised after an auth item or assignment is saved.
	 * @param CEvent $event the event parameter
	 */
	public function onAfterSave($event) {
		$this->raiseEvent('onAfterSave',$event);
	}
}
