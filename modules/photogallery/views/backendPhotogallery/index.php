<?php
$this->caption = "Пакетная загрузка фотографий";
$this->breadcrumbs = array(
  $ownerModel->getObjectInstance()->getName() => Yii::app()->createUrl(
    BackendModule::ROUTE_INSTANCE_LIST, array(
      ObjectUrlRule::PARAM_OBJECT => $ownerModel->getIdObject(), //TODO тут еще должен быть параметр с представлением
  )),
  $model->getObjectInstance()->getName().
    ' &quot;'.CHtml::encode($ownerModel->{$ownerModel->getObjectInstance()->getFieldCaption()}).'&quot;' =>  Yii::app()->createUrl(
    BackendModule::ROUTE_INSTANCE_LIST, array(
      ObjectUrlRule::PARAM_OBJECT => $model->getIdObject(),
      PhotogalleryPhoto::URL_PARAM_OBJECT => $ownerModel->getIdObject(),
      PhotogalleryPhoto::URL_PARAM_INSTANCE => $ownerModel->getIdInstance(),
  )),
  $this->caption => Yii::app()->createUrl('photogallery/backendPhotogallery/index', array(
    'objectId' => HU::get(PhotogalleryPhoto::URL_PARAM_OBJECT),
    'instanceId' => HU::get(PhotogalleryPhoto::URL_PARAM_INSTANCE),  
  )),
);
if (!empty($this->breadcrumbs)) { // Цепочка навигации
  $this->widget('BreadcrumbsWidget', array(
    'links' => $this->breadcrumbs,
  ));
}



Yii::import('xupload.models.XUploadForm');
$id = 'multi-file-upload';
?><div class="field-file-list-upload" id="<?php echo $id; ?>"><?php
$this->widget('fileUpload.fileUploadWidget.FileUploadWidget', array(
  'id' => $id,
  'multiple' => true,
  'scriptFile' => false,
  'url' =>  array('photogallery/backendPhotogallery/filesUpload',
    'ownerObjectId' => $ownerModel->getIdObject(), 
    'ownerInstanceId' => $ownerModel->getIdInstance(),
  ),
  'formClass' => 'fileUpload.FileUploadForm',
  'mainModel' => $model,
  'objectParameter' => $objectParameter,
  'formView' => 'photogallery.backend.upload.views.form',
  'uploadView' => 'photogallery.backend.upload.views.upload',
  'downloadView' => 'photogallery.backend.upload.views.download',
  'enableDeleting' => false,
  'thumbConfig' => array(
    'width' => 70,
    'height' => 50,
    'crop' => 'top',
    'postfix' => '_da',
  ),
  'options' => array(
    'acceptFileTypes' => '/(\.|\/)(gif|jpe?g|png)$/i',
    
  ),
));
?></div>