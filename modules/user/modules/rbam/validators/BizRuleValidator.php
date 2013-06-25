<?php
/* SVN FILE: $Id: BizRuleValidator.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* BizRule Validator class file.
* Validation for the business rule.
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
/**
* BizRule Validator class
* @package		RBAM
*/
class BizRuleValidator extends CValidator {
	/**
	* Validator to ensure that if data is given the item also has a business rule.
	* @param CModel model being validated
	* @param string attribute being validated
	*/
	protected function validateAttribute($model, $attribute) {
	  if (!empty($model->data) && empty($model->bizrule))
			$model->addError('bizrule', Yii::t('RbamModule.validation','cannot be empty if data supplied'));
	}
}
