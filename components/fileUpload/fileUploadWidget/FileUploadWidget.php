<?php
Yii::import('xupload.XUpload');
class FileUploadWidget extends XUpload {
  public $multiple = false;
  public $showForm = false;
  public $attribute = 'file';
  public $autoUpload = true;
  public $createThumb = true;
  public $thumbConfig = array();
  public $enableDeleting = true;
  /**
   * @var ObjectParameter
   */
  public $objectParameter;
  public $formClass = 'fileUpload.FileUploadForm';
  /**
   * Основная модель, к которой загружаются файлы
   * @var CActiveRecord
   */
  public $mainModel;
  
  public function init() {
    parent::init();
    if ($this->model === null) {
      $model = Yii::createComponent(array('class' => $this->formClass));
      $model->objectId = $this->objectParameter->id_object;
      $model->parameterId = $this->objectParameter->id_parameter;
      if ($this->mainModel->isNewRecord) {
        if (!$this->mainModel->getTmpId()) {
          $this->mainModel->setTmpId($this->generateTmpId());
        }
        $model->tmpId = $this->mainModel->getTmpId();
      } else {
        $model->instanceId = $this->mainModel->getIdInstance();
      }
      $this->model = $model;
    }
    
    if ($this->uploadTemplate === null) {
      $this->uploadTemplate = 'template-upload-'.$this->id;
    }
    if ($this->downloadTemplate === null) {
      $this->downloadTemplate = 'template-download-'.$this->id;
    }
    if (!isset($this->htmlOptions['id'])) {
      $this->htmlOptions['id'] = $this->id;
    }
    $this->options = CMap::mergeArray($this->options, array(
      'formData' => $this->model->toRequestParams(),
      'uploadTemplateId' => $this->uploadTemplate,
      'downloadTemplateId' => $this->downloadTemplate,
    ));
    if (!array_key_exists('previewMaxHeight', $this->options) && array_key_exists('height', $this->thumbConfig)) {
      $this->options['previewMaxHeight'] = $this->thumbConfig['height'];
    }
    if (!array_key_exists('previewMaxWidth', $this->options) && array_key_exists('width', $this->thumbConfig)) {
      $this->options['previewMaxWidth'] = $this->thumbConfig['width'];
    }
  }
  public function generateTmpId() {
    return md5(time().rand());
  }
  
  public function getFiles() {
    $attributes = array(
      'id_object' => $this->model->objectId,
      'id_parameter' => $this->model->parameterId,
      'id_parent_file' => null,
    );
    if ($this->model->instanceId) {
      $attributes['id_instance'] = $this->model->instanceId;
    } else {
      $attributes['id_tmp'] = $this->model->tmpId;
    }
    return File::model()->findAllByAttributes($attributes);
  }
  public function getFilesForJson() {
    $files = $this->getFiles();
    $res = array();
    foreach ($files as $file) {
      $fileJson = array(
        'fileId' => $file->id_file,
        'url' => $file->getUrlPath(),
        'name' => $file->getName(),
        'readebleFileSize' => $file->getReadableFileSize(),
      );
      if ($this->createThumb && $file->getIsImage()) {
        if ($thumb = $this->getPreview($file)) {
          $fileJson = array_merge($fileJson, array('thumbnail_url' => $thumb->getUrlPath()));
        }
      }
      if ($this->enableDeleting && !$this->objectParameter->not_null) {
        $route = '';
        $params = array();
        if (is_array($this->url)) {
          $route = $this->url[0];
          $params = array_slice($this->url, 1);
        }
        $fileJson = array_merge($fileJson, array(
          "delete_url" => Yii::app()->createUrl($route, array_merge($params, array(
            "_method" => "delete",
            "fileId" => $file->id_file,
          ))),
          "delete_type" => "POST",
        ));
      }
      $res[] = $fileJson;
    }
    return $res;
  }
  public function getPreview($file) {
    $paramsNames = array('width', 'height', 'postfix', 'cropType', 'quality', 'resize');
    $params = array();
    foreach ($paramsNames as $name) {
      if (array_key_exists($name, $this->thumbConfig)) {
        $params[] = $this->thumbConfig[$name];
      }
    }
    return call_user_func_array(array($file, 'getPreview'), $params);
  }

  public function publishAssets() {
    $assets = Yii::getPathOfAlias('ygin.ext.xupload.assets.img');
    Yii::app()->clientScript->addDependResource('jquery.fileupload-ui.css', array(
      $assets.'/loading.gif' => '../img/',
      $assets.'/progressbar.gif' => '../img/',
    ));
    parent::publishAssets();
  }

}