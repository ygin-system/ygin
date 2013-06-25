<?php
class BackendPhotogalleryController extends DaBackendController {
  public function actions() {
    return array_merge(parent::actions(), array(
      'filesUpload' => array(
        'class' => 'fileUpload.FileUploadAction',
        'multiple' => true,
        'createThumb' => true,
        'rewriteIfFileExist' => false,
        'thumbConfig' => array(
          'width' => 70,
          'height' => 50,
          'crop' => 'top',
          'postfix' => '_da',
        ),
        'onBeforeUploadValidate' => array($this, 'createInstance'),
      ),
    ));
  }
  public function actionIndex($objectId, $instanceId) {
    $model = new PhotogalleryPhoto();
    if (!$model->asa('FileUploadableBehavior') instanceof FileUploadableBehavior) {
      $model->attachBehavior('FileUploadableBehavior', array(
        'class' => 'fileUpload.FileUploadableBehavior',
        'resetScope' => true,
      ));
    }
    $ownerModel = $this->loadOwnerObjectModel($objectId, $instanceId);
    $objectParameter = $model->getObjectInstance()->getParameterObjectByField('file');
    $this->render('index', array(
      'model' => $model, 
      'objectParameter' => $objectParameter,
      'ownerModel' => $ownerModel,
    ));
  }
  public function createInstance(CEvent $event) {
    $objectId = HU::get('ownerObjectId');
    $instanceId = HU::get('ownerInstanceId');
    if (!($objectId && $instanceId)) {
      throw new CHttpException(400, 'Bad request.');
    }
    $formModel = $event->sender->getFormModel(); 
    $ownerModel = $this->loadOwnerObjectModel($objectId, $instanceId);
    $photo = new PhotogalleryPhoto('backendInsert');
    $photo->id_photogallery_object = $ownerModel->getIdObject();
    $photo->id_photogallery_instance = $ownerModel->getIdInstance();
    $photo->save(false);
    $formModel->instanceId = $photo->id_photogallery_photo;
    $formModel->objectId = $photo->getIdObject();
    $formModel->tmpId = null;
  }
  public function loadOwnerObjectModel($objectId, $instanceId) {
    $ownerObject = DaObject::getById($objectId);
    $this->throw404IfNull($ownerObject);
    $ownerModel =  $ownerObject->getModel()->findByPk($instanceId);
    $this->throw404IfNull($ownerModel);
    return $ownerModel;
  }
}