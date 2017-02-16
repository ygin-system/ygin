<?php

class FeedbackController extends Controller {
  
  public function actionIndex() {
    $model = BaseActiveRecord::newModel('Feedback');
    $modelClass = get_class($model);
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'feedbackForm') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
    if (isset($_POST[$modelClass])) {
      $model->attributes=$_POST[$modelClass];
      $model->onAfterSave = array($this, 'sendMessage'); //Регистрируем обработчик события
      if ($model->save()) {
        Yii::app()->user->setFlash('feedback-success', 'Спасибо за обращение. Ваше сообщение успешно отправлено.');
      } else {
        // вообще сюда попадать в штатных ситуациях не должны
        // только если кул хацкер резвится
        Yii::app()->user->setFlash('feedback-message', CHtml::errorSummary($model, '<p>Не удалось отправить форму</p>'));
      }
    }
    $this->redirect(Yii::app()->user->returnUrl);
  }
  
  public function sendMessage(CEvent $event) {
    Yii::app()->notifier->addNewEvent(
      Yii::app()->getModule('feedback')->idEventType,
      $this->renderPartial('/message_email', array('feedback' => $event->sender), true)
    );
  }
  
}