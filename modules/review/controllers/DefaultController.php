<?php

class DefaultController extends Controller {
  
  protected $urlAlias = "review";

  public function actionIndex() {
    $model = BaseActiveRecord::newModel('Review');
    $modelClass = get_class($model);
    if (isset($_POST['ajax'])) {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }

    if (isset($_POST[$modelClass])) {
      $model->attributes = $_POST[$modelClass];
      $model->visible = $this->module->moderate ? 0 : 1;
      $model->onAfterSave = array($this, 'sendMessage');
      if ($model->save()) {
        Yii::app()->user->setFlash('reviewAdd', 'Спасибо, ваш отзыв отправлен.');
        $this->refresh();
      }
    }
    
    $criteria = new CDbCriteria();
    $criteria->condition = 'visible = 1';
    $criteria->order = 'create_date DESC';

    $dataProvider = new CActiveDataProvider($modelClass, array(
      'criteria' => $criteria,
      'pagination' => array(
         'pageSize' => $this->module->pageSize,
      ),
    ));

    $this->render('/index', array(
      'dataProvider' => $dataProvider,
      'model' => $model,
    ));
  }
  
  public function sendMessage(CEvent $event) {
    Yii::app()->notifier->addNewEvent(
      $this->module->idEventType, 
      $this->renderPartial('/message_email', array('review' => $event->sender), true)
    );
  }

}