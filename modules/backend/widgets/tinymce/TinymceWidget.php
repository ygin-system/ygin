<?php

class TinymceWidget extends VisualElementWidget {

  public $options = array();

  public function init() {
    parent::init();
    $this->model->addValidator(CValidator::createValidator('safe', $this->model, $this->attributeName, array('on'=>'backendInsert, backendUpdate')));
  }

  public function onPostForm(PostFormEvent $event) {
    $this->model->onAfterSave = array($this, 'afterSave');
  }
  public function afterSave($event) {
    /**
     * @var $model DaActiveRecord
     */
    $model = $event->sender;
    if ($model->isNewRecord) {
      if ($model->asa('FileUploadableBehavior') instanceof FileUploadableBehavior) {
        $tempValue = $model->getTmpId();
        $tmpDir = str_replace(Yii::getPathOfAlias('webroot'), '', Yii::getPathOfAlias('temp')).'/'.$tempValue.'/';
        $instDir = '/'.ltrim($model->getDir(), '/'); //TODO подумать, если ссылка будет на другой домен
        $savedModel = $this->getObject()->getModel()->findByPk($model->getIdInstance());
        $fname = $this->getObjectParameter()->field_name;
        $savedModel->{$fname} = str_replace($tmpDir, HFile::addSlashPath($instDir), $savedModel->{$fname});
        $savedModel->save(false, array($fname));
      }
    }
  }
}
