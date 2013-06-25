<?php
class DaCaptchaValidator extends CCaptchaValidator {
  /**
   * @var boolean Производить ли валидацию каптчи при ajax запросе
   */
  public $ajaxValidation = false;
  
  /**
   * Validates the attribute of the object.
   * If there is any error, the error message is added to the object.
   * @param CModel $object the object being validated
   * @param string $attribute the attribute being validated
   */
  protected function validateAttribute($object, $attribute) {
    if (!$this->ajaxValidation && Yii::app()->request->isAjaxRequest) {
      return;
    }
    parent::validateAttribute($object, $attribute);
  }
}