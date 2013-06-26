<?php
  class FaqEventHandler extends BackendEventHandler {
    public function onPostForm(PostFormEvent $event) {
      $model = $event->model;
      $send = $model->send;
      $email = $model->email;
      $answer = $model->answer;

      if ($send == 1 && $model->validate()) {
        Yii::app()->notifier->addNewEvent(
          Question::ID_EVENT_TYPE,
          $event->sender->renderPartial('ygin.modules.faq.views.answer',array(
            'model' => $model,
          ), true),
          Question::ID_EVENT_SUBSCRIBER,
          array($email),
          $model->primaryKey
        );
        $model->send = 0;
      }
    }
  }