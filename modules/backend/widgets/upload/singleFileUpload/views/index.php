<?php
Yii::import('xupload.models.XUploadForm');
$id = 'single-file-upload-'.$this->id;
?><div class="single-file-upload-row" id="<?php echo $id; ?>"><?php
$this->widget('fileUpload.fileUploadWidget.FileUploadWidget', array(
  'id' => $id,
  'multiple' => false,
  'scriptFile' => false,
  'url' =>  array('backend/yginFile/fileUpload'),
  'formClass' => 'fileUpload.FileUploadForm',
  'mainModel' => $this->model,
  'objectParameter' => $this->getObjectParameter(),
  'formView' => 'backend.widgets.upload.singleFileUpload.views.form',
  'uploadView' => 'backend.widgets.upload.singleFileUpload.views.upload',
  'downloadView' => 'backend.widgets.upload.singleFileUpload.views.download',
  'thumbConfig' => array(
    'width' => 70,
    'height' => 50,
    'crop' => 'top',
    'postfix' => '_da',
  ),
  'options' => array(
    'prependFiles' => true,
  ),
));
?></div>