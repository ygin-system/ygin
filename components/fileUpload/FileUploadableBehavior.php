<?php
class FileUploadableBehavior extends CActiveRecordBehavior {
  private $_tmpId = null;
  public $resetScope = false;
  private $_objectParameters = null;
  private $_files = null;
  
  protected function getFiles() {
    if ($this->_files === null) {
      $this->_files = array();
      foreach ($this->getFileObjectParameters() as $objectParam) {
        $attributes = array(
          'id_object' => $this->owner->getIdObject(),
          'id_parameter' => $objectParam->id_parameter,
        );
        if ($this->owner->isNewRecord) {
          $attributes['id_tmp'] = $this->getTmpId();
        } else {
          $attributes['id_instance'] = $this->owner->getIdInstance();
        }
        $files = File::model()->findAllByAttributes($attributes);
        if ($files) {
          $this->_files[$objectParam->id_parameter] = $files;
        } 
      }
    }
    return $this->_files;
  }
  protected function getFileObjectParameters() {
    if ($this->_objectParameters === null) {
      $object = DaObject::getById($this->owner->getIdObject(), true);
      foreach ($object->parameters as $objectParam) {
        if ($objectParam->id_parameter_type == DataType::FILE ||
            $objectParam->id_parameter_type == DataType::FILES) {
          $this->_objectParameters[] = $objectParam;
        }
      }
    }
    return $this->_objectParameters;
  }
  public function beforeValidate($event) {
    //устанавливаем модели идешники загруженных файлов
    foreach ($this->getFileObjectParameters() as $objectParam) {
      if ($objectParam->id_parameter_type == DataType::FILE && 
          ($files = HArray::val($this->getFiles(), $objectParam->id_parameter, array()))) {
        $mainFile = null;
        foreach ($files as $file) {
          if (empty($file->id_parent_file)) {
            $mainFile = $file;
            break;
          }
        }
        if ($mainFile) {
          $this->owner->{$objectParam->field_name} = $mainFile->id_file;
        }
      }
    }
  }
  public function afterSave($event) {
    if ($this->owner->isNewRecord && ($tmpId = $this->getTmpId())) {
      if ($this->owner instanceof DaInstance) {
        $finder = $this->owner;
      } else {
        $finder = $this->owner->model();
      }
      if ($this->resetScope) {
        $finder->resetScope();
      }
      $model = $finder->findByIdInstance($this->owner->getIdInstance());
      foreach ($this->getFiles() as $files) {
        foreach ($files as $file) {
          $modelDir = $model->getDir(true);
          $file->file_path = $modelDir.$file->getName();
          $file->id_instance = $model->getIdInstance();
          $file->id_tmp = null;
          $file->save(false);
        }
      }
      if (count($this->getFiles()) > 0) {
        //переносим файлы
        $mpDir = Yii::getPathOfAlias('temp').'/'.$this->getTmpId();
        HFile::copyDirectory($mpDir, $model->getDir(true, true));
        HFile::removeDirectoryRecursive($mpDir, true);
      }
    }
  }
  public function getTmpId() {
    return $this->_tmpId;
  }
  public function setTmpId($id) {
    $this->_tmpId = $id;
  }
  public function attach($owner) {
    parent::attach($owner);
    $owner->getValidatorList()->add(
      CValidator::createValidator('safe', $this->owner, array('tmpId'))
    );
  }
}