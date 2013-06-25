<?php
/* SVN FILE: $Id: RbamUserBehavior.php 21 2011-02-17 15:28:27Z Chris $*/
/**
* RBAM User Behavior class file.
* Provides additional features used by RBAM to the user model.
*
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 21 $
* @license		BSD License (see documentation)
*/
/**
* RBAM User Behavior class
* @package		RBAM
*/
class RbamUserBehavior extends CModelBehavior {
	const COMMA = '__##comma##__';

	/**
	* @property-read string the user name
	*/
	private $_name;

	/**
	* Returns the user's name.
	* @return string the user's name.
	*/
	public function getRbamName() {
		if ($this->_name===null) {
			$owner = $this->getOwner();
			$attribute = Yii::app()->findModule('rbam')->userNameAttribute;

		if (is_string($attribute) && strpos($attribute, ',')!==false)
			$attribute = explode(',', str_replace('\,',self::COMMA,$attribute));

			if (is_array($attribute)) {
				$glue = str_replace(self::COMMA,',',array_shift($attribute));
				$end = end($attribute);
				$initials = ((is_array($end) || strpos($end, self::COMMA)!==false || strpos($end, ',')!==false)?array_pop($attribute):array());
				if (!empty($initials)) {
					if (is_string($initials))
						$initials = explode(',', str_replace('\,',self::COMMA,str_replace(self::COMMA,',',$initials)));
					$append = str_replace(self::COMMA,',',array_shift($initials));
				}

				$attributes = array();
				foreach ($attribute as $attr) {
					$value = CHtml::value($owner,$attr);
					if (!empty($value))
						$attributes[] = (in_array($attr, $initials)?substr($value,0,1).$append:$value);
				}
				$this->_name =  join($glue, $attributes);
			}
			else
				$this->_name = $owner->$attribute;
		}
		return $this->_name;
	}
}