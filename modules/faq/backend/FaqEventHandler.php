<?php
  class FaqEventHandler extends BackendEventHandler {
    public function onPostForm(PostFormEvent $event) {
      $model = $event->model;
      $send = $model->send;
      $email = $model->email;
      $answer = $model->answer;
      $idEventTypeAnswer = Yii::app()->getModule('faq')->idEventTypeAnswer;
      $idEventSubscriberAnswer = Yii::app()->getModule('faq')->idEventSubscriberAnswer;

      if ($send == 1 && $model->validate() && $idEventTypeAnswer != null && $idEventSubscriberAnswer != null) {
        Yii::app()->notifier->addNewEvent(
          $idEventTypeAnswer,
          $event->sender->renderPartial('ygin.modules.faq.views.answer',array(
            'model' => $model,
          ), true),
          $idEventSubscriberAnswer,
          array($email),
          $model->primaryKey
        );
        $model->send = 0;
      }
    }
  }