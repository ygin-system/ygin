<?php

class DefaultController extends Controller {
  
  protected $urlAlias = "faq";

  public function actionIndex() {
    $model = BaseActiveRecord::newModel('Question');
    $modelClass = get_class($model);

    if (isset($_POST['ajax'])) {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }

    if (isset($_POST[$modelClass])) {
      $model->attributes = $_POST[$modelClass];
      $model->visible = $this->module->moderate ? BaseActiveRecord::FALSE_VALUE : BaseActiveRecord::TRUE_VALUE;
      $model->onAfterSave = array($this, 'sendMessage');
      if ($model->save()) {
        Yii::app()->user->setFlash('questionAdd', 'Спасибо, ваш вопрос отправлен.');
        $this->refresh();
      }
    }
    
    $criteria = new CDbCriteria();
    $criteria->condition = 'visible = 1';
    $criteria->order = 'ask_date DESC';

    $dataProvider = new CActiveDataProvider('Question', array(
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
      Yii::app()->getModule('faq')->idEventType,
      $this->renderPartial('/message_email', array('question' => $event->sender), true)
    );
  }

}