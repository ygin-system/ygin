<?php
/* SVN FILE: $Id: DataValidator.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* Data Validator class file.
* Validation for the additional data.
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
/**
* Data Validator class
* @package		RBAM
*/
class DataValidator extends CValidator {
	/**
	* Validator to ensure that if data is referred to in the business rule that data is supplied.
	* @param CModel model being validated
	* @param string attribute being validated
	*/
	protected function validateAttribute($model, $attribute) {
	  if (!empty($model->bizrule) && strpos($model->bizrule,'$data')!==false && empty($this->data))
			$model->addError('data', Yii::t('RbamModule.validation','cannot be empty if referred to in the business rule'));
	}
}
