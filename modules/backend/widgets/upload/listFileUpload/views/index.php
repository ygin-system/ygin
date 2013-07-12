<?php
Yii::import('xupload.models.XUploadForm');
$id = 'list-file-upload-'.$this->id;
?><div class="field-file-list-upload" id="<?php echo $id; ?>"><?php
$this->widget('fileUpload.fileUploadWidget.FileUploadWidget', array(
  'id' => $id,
  'multiple' => true,
  'scriptFile' => false,
  'url' =>  array('backend/yginFile/listFileUpload'),
  'formClass' => 'fileUpload.FileUploadForm',
  'mainModel' => $this->model,
  'objectParameter' => $this->getObjectParameter(),
  'formView' => 'backend.widgets.upload.listFileUpload.views.form',
  'uploadView' => 'backend.widgets.upload.listFileUpload.views.upload',
  'downloadView' => 'backend.widgets.upload.listFileUpload.views.download',
  'thumbConfig' => array(
    'width' => 70,
    'height' => 50,
    'crop' => 'top',
    'postfix' => '_da',
  ),
));
?></div>