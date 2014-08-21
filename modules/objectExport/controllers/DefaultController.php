<?php
class DefaultController extends Controller {
  public $layout = 'main';
  
  protected function performAjaxValidation($model)
  {
    if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
    {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  
  public function actionIndex() {
    $model = new ExportForm;
    $modelClass = get_class($model);
    $this->performAjaxValidation($model);
    if (isset($_POST[$modelClass])) {
      //HU::dump($_POST);exit;
      $model->setAttributes($_POST[$modelClass], false);
      $valid=true;
      foreach($_POST[$modelClass] as $i=>$item)
      {
        if(isset($_POST[$modelClass][$i]) && is_array($_POST[$modelClass][$i])) {
          $model->checkAttributes[] = $item['checkAttributes'];
          $model->newObjectParameters[] = $item['newObjectParameters'];
          $model->objectParameters[] = $item['objectParameters'];
        }
        $valid=$model->validate() && $valid;
      }
      if($model->validate() && $valid) {
        $sqlDump = $model->getDump();
        echo $sqlDump;
        Yii::app()->end();
      } else {
        HU::dump($model->errors);exit;
      }
    }
    $objects = DaObject::model()->findAll(array(
      'condition' => 'table_name IS NOT NULL',
      'order' => 'name ASC',
    ));
    $this->render('index', array(
        'model' => $model,
        'objects' => $objects
    ));
  }

  /**
   * @param string $objectId
   * Свойства клонируемого объекта
   * return ObjectParameter[]
   */
  public function actionObjectParameters($objectId) {
    $model = new ExportForm();
    $objectParameters = ObjectParameter::model()->findAll('`id_object` = ?', array($objectId));
    $this->renderPartial('paramsList', array('objectParameters' => $objectParameters, 'model' => $model));
    //$objectParameters = CHtml::listData($objectParameters,'id_parameter','caption');
    //echo CHtml::activeCheckBoxList($model, 'objectParameters', $objectParameters, array('checked'));
  }
}