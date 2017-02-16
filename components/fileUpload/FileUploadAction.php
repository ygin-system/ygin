<?php

class FileUploadAction extends CAction {
  
  public $formClass = 'fileUpload.FileUploadForm';
  
  /**
   * @var CFormModel
   */
  private $_formModel;
  /**
   * @var File
   */
  private $_deletedFile;
  /**
   * Атрибут с файлом в $formModel
   * @var string
   */
  public $fileAttribute = 'file';
  /**
   * Разрешена ли множественная загрузка файлов
   * @var boolean
   */
  public $multiple = false;
  /**
   * Правило для формирования имени файла
   * @var string
   */
  public $filenameRule = null;
  /**
   * Имя загруженного файла
   * @var string
   */
  public $fileName = null;
  /**
   * Что делать, если файл уже существует
   * true - перезаписать
   * false - создать файл с новым именем
   * @var boolean
   */
  public $rewriteIfFileExist = true;
  /**
   * @var File
   */
  public $savedFile = null;
  /**
   * Нужно ли создавать миниатюры
   * @var boolean
   */
  public $createThumb = true;
  /**
   * Конфигурация для создания миниатюры
   * @var array
   */
  public $thumbConfig = array();
  
  /**
   * Доступно ли удаление файла
   * @var boolean
   */
  public $enableDeleting = true;
  /**
   * Имя GET перменной с идентификатором файла
   * @var string
   */
  public $fileIdVar = 'fileId';
  
  /**
   * Нужно ли выполнять транслитерацию имени файла
   * @var boolean
   */
  private $_translitFileName;
  
  public function run() {
    $response = array();
    if ($this->getIsDeleteRequest()) {
      $this->handleDelete();
      $response = $this->getDeleteResponse();
    } else {
      $this->handleUpload();
      $response = $this->getUploadResponse();
    }
    $this->sendHeaders();
    echo json_encode($response);
    Yii::app()->end();
  }
  protected function handleUpload() {
    $this->beforeUpload();
    $formModel = $this->getFormModel();
    if (!$formModel instanceof FileUploadForm) {
      throw new ErrorException('Модель формы должна расширять класс FileUploadForm.');
    }
    $formModel->attributes = Yii::app()->request->getPost(get_class($formModel), array());
    $formModel->{$this->fileAttribute} = CUploadedFile::getInstance($formModel, $this->fileAttribute);
    $uploadedFile = $formModel->{$this->fileAttribute};
    if ($this->beforeUploadValidate()) {
      if ($formModel->validate()) {
        if ($this->fileName === null) {
          if ($this->filenameRule != null) {
            $this->fileName = $this->evaluateExpression($this->filenameRule,array('file'=>$uploadedFile));
          }
          if ($this->fileName === null) {
            $this->fileName = $uploadedFile->getName();
          }
          if ($this->getTranslitFileName()) {
            $this->fileName = HText::translit($this->fileName, '-');
          }
        }
        $oldFile = $this->getOldFile();
        if (!$this->checkAccess($oldFile)) {
          throw new CHttpException(403, 'Вы не можете выполнить данную операцию.');
        }
        $newFile = null;
        //Если существует старый файл, то его надо либо заменить, либо создать файл с новым именем
        if ($oldFile !== null) {
          if ($this->rewriteIfFileExist) {
            if (file_exists($oldFile->getFilePath(true))) {
              unlink($oldFile->getFilePath(true));
            }
            $oldFile->deleteChildFile();
            $newFile = $oldFile;
          } else {
            $this->fileName = $this->getCopyFileName($oldFile->getFilePath(true));
            $newFile = new File();
          }
        } else {
          $newFile = new File();
        }
        
        $destDir = '';
        if ($formModel->instanceId) {
          $model = $formModel->getInstanceModel();
          if ($model == null) {
            throw new CHttpException(404, 'Экземпляр модели id_object = '.$formModel->objectId.', с id_instance = '.$formModel->instanceId.' не найден.');
          }
          $destDir = $model->getDir(false, true);
        } else {
          $destDir = Yii::getPathOfAlias('temp').'/'.$formModel->tmpId;
        }
        $destDir = $this->createDir($destDir);
        $normalazedPath = rtrim($destDir, '/').'/';
        $path = $normalazedPath.$this->fileName;
        //возможно такой файл уже существует
        //тогда надо сгенерить новое имя
        if (file_exists($path)) {
          $this->fileName = $this->getCopyFileName($path);
          $path = $normalazedPath.$this->fileName;
        }
        if (!$uploadedFile->saveAs($path)) {
          throw new CHttpException(500, 'Не удалось сохранить файл "'.$path.'".');
        } else {
          chmod($path, 0777);
        }
        $newFile->create_date = time();
        $newFile->id_object = $formModel->objectId;
        $newFile->id_instance = $formModel->instanceId;
        $newFile->id_parameter = $formModel->parameterId;
        $newFile->id_tmp = $formModel->tmpId;
        $newFile->file_path = $this->getRelativePath($path);
        if (!$newFile->save()) {
          throw new CHttpException(500, 'Не удалось сохранить модель File: '."\n".$this->getModelErrors($newFile));
        }
        $this->savedFile = $newFile;
        
        //если модель существующая и тип поля - Файл, то сразу обновим поле
        if ($formModel->instanceId) {
          $objectParameter = $formModel->getObjectParameter();
          if ($objectParameter == null) {
            throw new CHttpException(404, 'Параметр объекта id_object = '.$formModel->objectId.', id_parameter = '.$formModel->parameterId.' не найден.');
          }
          if ($objectParameter->id_parameter_type == DataType::FILE) {
            $model = $formModel->getInstanceModel();
            $model->{$objectParameter->field_name} = $newFile->id_file;
            $model->save(false, array($objectParameter->field_name));
          }
        }
        $this->afterUpload();
      } else {
        if (isset($formModel->errors['file'])) {
          throw new DaHttpException(400, $this->getModelErrors($formModel)); // без логирования
        } else {
          throw new CHttpException(400, $this->getModelErrors($formModel));
        }
      }
    }
  }
  protected function sendHeaders()
  {
    header('Vary: Accept');
    if (isset($_SERVER['HTTP_ACCEPT']) && (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
      header('Content-type: application/json');
    } else {
      header('Content-type: text/plain');
    }
  }
  protected function handleDelete() {
    $this->beforeDelete();
    $fileId = Yii::app()->request->getQuery($this->fileIdVar);
    if (empty($fileId)) {
      throw new CHttpException(400, 'Не указан fileId.');
    }
    if (($file = File::model()->findByPk($fileId)) == null) {
      throw new CHttpException(404, 'Файл с id_file = '.$fileId.' не найден.');
    }
    if (!$this->checkAccess($file)) {
      throw new CHttpException(403, 'Вы не можете выполнить данную операцию.');
    }
    $object = DaObject::getById($file->id_object);
    $objectParameter = $object->getParameterObjectByIdParameter($file->id_parameter);
    //если свойство NOT NULL, то нельзя удалять файл
    if ($objectParameter->not_null) {
      throw new CHttpException(500, 'Не возможно удалить NOT NULL свойство.');
    }
    if (!$file->delete()) {
      throw new CHttpException(500, 'Не удалось удалить файл с id_file = '.$fileId.'.');
    }
    
    if ($objectParameter->id_parameter_type == DataType::FILE && $file->id_instance) {
      //если это свойство типа Файл, то нужно занулить соответсвующее поле у модели
      $instanceModel = $object->getModel()->findByIdInstance($file->id_instance);
      $instanceModel->{$objectParameter->field_name} = null;
      $instanceModel->save(false, array($objectParameter->field_name));
    }
    $this->_deletedFile = $file;
    $this->afterDelete();
  }
  protected function getIsDeleteRequest() {
    return isset($_GET["_method"]) && $_GET["_method"] == "delete";
  }
  public function setFormModel($model) {
    $this->_formModel = $model;
  }
  public function getFormModel() {
    if ($this->_formModel === null) {
      $this->_formModel = Yii::createComponent(array('class' => $this->formClass));
    }
    return $this->_formModel;
  }
  protected function checkAccess($file) {
    if($this->hasEventHandler('onCheckAccess')) {
      $event=new CModelEvent($this);
      $event->params['file'] = $file;
      $this->onCheckAccess($event);
      return $event->isValid;
    }
    else
      return true;
  }
  protected function beforeUpload() {
    if ($this->hasEventHandler('onBeforeUpload')) {
      $this->onBeforeUpload(new CEvent($this));
    }
  }
  protected function afterUpload() {
    if ($this->hasEventHandler('onAfterUpload')) {
      $this->onAfterUpload(new CEvent($this));
    }
  }
  protected function beforeUploadValidate() {
    if($this->hasEventHandler('onBeforeUploadValidate')) {
      $event=new CModelEvent($this);
      $this->onBeforeUploadValidate($event);
      return $event->isValid;
    }
    else
      return true;
  }
  protected function beforeDelete() {
    if ($this->hasEventHandler('onBeforeDelete')) {
      $this->onBeforeDelete(new CEvent($this));
    }
  }
  protected function afterDelete() {
    if ($this->hasEventHandler('onAfterDelete')) {
      $this->onAfterDelete(new CEvent($this));
    }
  }
  public function onCheckAccess($event) {
    $this->raiseEvent('onCheckAccess', $event);
  }
  public function onBeforeUpload($event) {
    $this->raiseEvent('onBeforeUpload', $event);
  }
  public function onAfterUpload($event) {
    $this->raiseEvent('onAfterUpload', $event);
  }
  public function onBeforeDelete($event) {
    $this->raiseEvent('onBeforeDelete', $event);
  }
  public function onAfterDelete($event) {
    $this->raiseEvent('onAfterDelete', $event);
  }
  public function onBeforeUploadValidate($event) {
    $this->raiseEvent('onBeforeUploadValidate', $event);
  }
  protected function getModelErrors($model) {
    $errors = $model->getErrors();
    $res = '';
    foreach ($errors as $attrName => $attrErrors) {
      $res .= implode("\n", $attrErrors)."\n";
    }
    return $res;
  }
  protected function getOldFile() {
    $oldFile = null;
    $formModel = $this->getFormModel();
    $attributes = array(
      'id_object' => $formModel->objectId,
      'id_instance' => $formModel->instanceId,
      'id_parameter' => $formModel->parameterId,
      'id_tmp' => $formModel->tmpId,
      'id_parent_file' => null,
    );
    if ($this->multiple === false) {
      $oldFile = File::model()->findByAttributes($attributes);
    } else {
      $fileName = $this->fileName;
      $oldFile = File::model()->findByAttributes(
        $attributes,
        'LOWER(RIGHT(file_path, '.mb_strlen($fileName).')) = :FILE_NAME',
        array(':FILE_NAME' => mb_strtolower($fileName))
      );
    }
    return $oldFile;
  }
  protected function getCopyFileName($filePath) {
    $path = HFile::getDir($filePath);
    $files = (file_exists($path) ? HFile::findFiles($path) : array());
    $files = array_flip($files);
    $ext = HFile::getExtension($this->fileName);
    $file = HFile::getFileNameByPath($this->fileName, true);
    $i = 0;
    $copyFileName = '';
    do {
      $copyFileName = $file.'('.(++$i).').'.$ext;
    } while (array_key_exists($copyFileName, $files));
    return $copyFileName;
  }
  protected function getRelativePath($directory) {
    return mb_substr($directory, mb_strlen(Yii::getPathOfAlias('webroot')) + 1);
  }
  protected function createDir($dir) {
    $array = explode('/', $this->getRelativePath($dir));
    $count = count($array);
    $fPath = Yii::getPathOfAlias('webroot');
    for ($i = 0; $i < $count; $i ++) {
      if (in_array(trim($array[$i]), array('', '.', '..'))) continue;
      
      $fPath .= '/'.$array[$i];
      if (!is_dir($fPath)) {
        umask(0);
        mkdir($fPath, 0777);
      }
    
      //Проверить права на папку
      $fileperms = substr(decoct(fileperms($fPath)), 2, 6);
      if (strlen($fileperms) == '3') $fileperms = '0' . $fileperms;
    
      if ($fileperms != '0777') {
        if (chmod($fPath, 0777) == false)
          throw new Exception("Права на папку ".$fPath." должны быть 0777");
      }
    }
    return $fPath;
  }
  protected function getUploadResponse() {
    $uploadedFile = $this->getFormModel()->{$this->fileAttribute};
    $savedFile = $this->savedFile;
    $response = array(
      "name" => $this->fileName,
      "type" => $uploadedFile->getType(),
      "size" => $uploadedFile->getSize(),
      "url" => $savedFile->getUrlPath(),
      "fileId" => $savedFile->id_file,
    );
    if ($savedFile->getIsImage() && $this->createThumb) {
      $paramsNames = array('width', 'height', 'postfix', 'cropType', 'quality', 'resize');
      $params = array();
      foreach ($paramsNames as $name) {
        if (array_key_exists($name, $this->thumbConfig)) {
          $params[] = $this->thumbConfig[$name];
        }
      }
      if ($thumb = call_user_func_array(array($savedFile, 'getPreview'), $params)) {
        $response = array_merge($response, array('thumbnail_url' => $thumb->getUrlPath()));
      }
    }
    $objectParameter = $this->getFormModel()->getObjectParameter();
    if ($this->enableDeleting && !$objectParameter->not_null) {
      $response = array_merge($response, array(
        "delete_url" => $this->getController()->createUrl($this->getId(), array(
          "_method" => "delete",
          "fileId" => $savedFile->id_file,
        )),
        "delete_type" => "POST"
      ));
    }
    return array('files' => array($response));
  }
  public function getDeleteResponse() {
    return array(
      'result' => true,
      'fileId' => $this->_deletedFile->id_file,
    );
  }
  public function setTranslitFileName($translit) {
    $this->_translitFileName = $translit;
  }
  public function getTranslitFileName() {
    if ($this->_translitFileName === null) {
      $this->_translitFileName = (bool)Yii::app()->params['translit_uploaded_file_name'];
    }
    return $this->_translitFileName;
  }
}