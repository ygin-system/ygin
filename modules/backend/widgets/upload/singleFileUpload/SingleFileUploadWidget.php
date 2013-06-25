<?php
Yii::import('backend.widgets.upload.BackendBaseUploadWidget');
class SingleFileUploadWidget extends BackendBaseUploadWidget {
  public function init() {
    parent::init();
    if ($this->getObjectParameter()->isRequired()) {
      $this->model->getValidatorList()->add(
        CValidator::createValidator(
          'required',
          $this->model,
          array($this->getObjectParameter()->getFieldName()), array('on' => 'backendInsert, backendUpdate')
      ));
    }
  }
}