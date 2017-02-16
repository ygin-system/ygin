<?php
class DispatchEvents extends SchedulerJob {
  public function run() {
    Yii::app()->getModule('mail'); //инициализируем модуль
    $count = Yii::app()->params['count_sent_mail_for_session']; //Кол-во отправляемых писем за раз (null - все)
    Yii::app()->notifier->setSentMailCount($count);
    Yii::app()->notifier->setDeletingDaysCount(Yii::app()->params['count_day_for_delete_event']);
    Yii::app()->notifier->dispatchNotifierEvents();
    return self::RESULT_OK;
  }
}