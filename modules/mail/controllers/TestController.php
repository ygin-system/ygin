<?php
class TestController extends DaFrontendController {
  
  public function actionAdd() {
    Yii::app()->notifier->addNewEvent(
      104,
      '<html><head><title>Тест</title></head><body><p style="font-size:40px">HTML Супер</p></body></html>',
      104,
      array('test@ygin.ru')
    );
    $this->render('ygin.modules.mail.controllers.test');
  }
  
  public function actionTest() {
    Yii::app()->notifier->onEmptyMessage = array($this, 'createMessage');
    Yii::app()->notifier->onBeforeSend = array($this, 'beforeSend');
    Yii::app()->notifier->dispatchNotifierEvents();
    $this->render('ygin.modules.mail.controllers.test');
  }
  
  public function beforeSend(NotifierComponentEvent $event) {
    Yii::trace('BeforeSave: '.$event->getMailMessage()->getSubject(), 'test.beforeSave');
  }
  
  public function createMessage(NotifierComponentEvent $event) {
    $subject = '';
    $msg = '';
    switch ($event->getNotifierEvent()->id_event_type) {
      case 103:
        /*
        $model = Question::model()->findByPk($event->getNotifierEvent()->id_instance);
        
        $msg = "Это тестовое сообщение id_event_type = {id_event_type}\n".
               "name: {name}\n".
               "question: {question}\n".
               "email: {email}";
        $msg = strtr($msg, array(
          '{id_event_type}' => 103,
          '{name}' => $model->name,
          '{question}' => $model->question,
          '{email}' => $model->email,
        ));
        */
        $msg = '<html><head><title>Тест</title></head><body><p>HTML Тест</p></body></html>';
        //$msg = '<table><tr><th>Заголовок 1</th><th>Заголовок 2</th></tr><tr><td>Данные 1</td><td>Данные 2</td></tr></table>';
        break;
    }
    $event->getMailMessage()->setBody($msg, 'text/html');
  }
}