<?php
Yii::import('fileUpload.FileUploadableBehavior');
class BackendBaseUploadWidget extends VisualElementWidget {
  public function init() {
    parent::init();
    if (!$this->model->asa('FileUploadableBehavior') instanceof FileUploadableBehavior) {
      $this->model->attachBehavior('FileUploadableBehavior', array(
        'class' => 'fileUpload.FileUploadableBehavior',
        'resetScope' => true,
      ));
    }
    Yii::app()->clientScript->registerCoreScript('jquery.ui');
  }
  public function getFiles() {
    $attributes = array(
      'id_object' => $this->model->getIdObject(),
      'id_parameter' => $this->getObjectParameter()->id_parameter,
      'id_instance' => $this->model->getIdInstance(),
      'id_parent_file' => null,
    );
    return File::model()->findAllByAttributes($attributes);
  }
}