<?php
class Notifier extends CApplicationComponent {
  /**
   * Последнее добавленное уведомление
   * @var NotifierEvent
   */
  private $_lastAddedEvent = null;
  
  /**
   * Количество дней, после которых проиходит удаление уведомлений
   * @var int
   */
  private $_deletingDaysCount = 90;
  /**
   * Количество уведомлений отправляемых за сессию
   * @var int
   */
  private $_sentMailCount = 3;
  
  public function getLastAddedEvent() {
    return $this->_lastAddedEvent;
  }
  protected function setLastAddedEvent($notifierEvent) {
    $this->_lastAddedEvent = $notifierEvent;
  }
  public function setDeletingDaysCount($count) {
    $this->_deletingDaysCount = $count;
  }
  public function getDeletingDaysCount() {
    return $this->_deletingDaysCount;
  }
  public function setSentMailCount($count) {
    $this->_sentMailCount = $count;
  }
  public function getSentMailCount() {
    return $this->_sentMailCount;
  }
  
  /**
   * Добавляет уведомления по sql выражению в типе уведомления
   */
  public function addNotifierEventsByQuery() {
    //Получаем все типы событий
    $notifierEventTypes = NotifierEventType::model()->findAll(array('order' => 'id_mail_account'));
    $c = count($notifierEventTypes);
    for ($i = 0; $i < $c; $i++) {
      $curType = $notifierEventTypes[$i];
      if ($curType->interval_value != null) {
        //Если таймаут со времени последнего выполнения не прошел, то пропускаем
        if (!$curType->getTimeoutIsExpired()) continue;
        $curType->updateLastTime();
      }
      
      $selectSql = trim($curType->selectQuery);
      if (empty($selectSql)) continue; //События добавляются вручную
      
      $needCache = NotifierEvent::getCacheSubscribersEmails();
      NotifierEvent::setCacheSubscribersEmails(true); //Заставляем кешировать результаты выборки подписчиков
      
      //Должны получить id_instance
      $dataReader = Yii::app()->db->createCommand($selectSql)->query();
      foreach ($dataReader as $row) {
        $idInstance = $row['id_instance'];
        $notifierEvent = new NotifierEvent();
        $notifierEvent->id_event_type = $curType->id_event_type;
        $notifierEvent->id_instance = $idInstance;
        $notifierEvent->save();
        $updateSql = trim($curType->doneQuery);
        if (empty($updateSql)) continue;
        //Отмечаем добавленные экземпляры
        Yii::app()->db->createCommand(
          strtr($updateSql, array('<<id_instance>>' => $idInstance))
        )->execute();
      }
      $dataReader->close();
      
      NotifierEvent::setCacheSubscribersEmails($needCache);
    }
  }
  
  /**
   * Удаляет устаревшие уведомления
   */
  public function clearExpiredNotifierEvents() {
    $seconds = 86400 * $this->getDeletingDaysCount();
    $t = time() - $seconds;
    $notifierEvents = NotifierEvent::model()->findAll('event_create < :TIME', array(':TIME' => $t));
    foreach ($notifierEvents as $event) {
      $event->delete();
    }
  }
  
  public function dispatchNotifierEvents() {
    $this->addNotifierEventsByQuery(); //TODO Вынести в отдельную задачу планировщика
    
    $notifierEvents = NotifierEvent::model()->getForSend($this->getSentMailCount());
    $this->send($notifierEvents);
    
    $this->clearExpiredNotifierEvents(); //TODO Вынести в отдельну задачу планировщика
  }
  
  public function send(array $events) {
    $eventsCount = count($events);
    if ($eventsCount == 0) return;
    
    $mailer = Yii::app()->mailer;
    $mailer->init();
    
    for ($i = 0; $i < $eventsCount; $i++) {
      $curEvent = $events[$i];
      $mailAccount = $curEvent->eventType->mailAccount;
      $mailerTransport = $mailer->getTransport()->setHost($mailAccount->host);
      
      if ($mailAccount->getIsNeedAuthorize()) { //нужна авторизация на сервере
        $mailerTransport
          ->setUsername($mailAccount->user_name)
          ->setPassword($mailAccount->user_password);
      } else {
        $mailerTransport
          ->setUsername(null)
          ->setPassword(null);
      }
      
      $eventsProcess = $curEvent->getEventsProcess();
      $eventsProcessCount = count($eventsProcess);
      for ($k = 0; $k < $eventsProcessCount; $k++) {
        $curEventProcess = $eventsProcess[$k];
        
        $mailMessage = new YiiMailMessage();
        $mailMessage->setTo($curEventProcess->email);
        $mailMessage->setSubject($curEvent->subject);
        $messageContent = '';
        if ($curEvent->event_message === null) {
          $ncEvent = new NotifierComponentEvent($this, $curEvent, $curEventProcess, $mailMessage);
          $this->onEmptyMessage(new NotifierComponentEvent($this, $curEvent, $curEventProcess, $mailMessage));
          if ($mailMessage->getBody() == null  && empty($ncEvent->params['messageContent'])) {
            $curEventProcess->saveAsSent();
            continue;
          } elseif (!empty($ncEvent->params['messageContent'])) {
            $messageContent = $ncEvent->params['messageContent'];
          }
        } else {
          $messageContent = $curEvent->event_message;
        }
        
        if ($mailMessage->getFrom() == null) { //если не указан отправитель, то берем из настроек аккаунта
          if (!empty($mailAccount->from_name)) {
            $mailMessage->setFrom(array($mailAccount->email_from => $mailAccount->from_name));
          } else {
            $mailMessage->setFrom($mailAccount->email_from);
          }
        }
        //если тема не указана, то в качестве темы устанавливаем название типа события
        if ($mailMessage->getSubject() == null) {
          $mailMessage->setSubject($curEvent->eventType->name);
        }
        
        //Если есть что прикреплять
        if (!empty($messageContent)) {
          $eventFormat = $curEventProcess->eventSubscriber->eventFormat;
          switch ($eventFormat->place) {
            case NotifierEventFormat::PLACE_TEXT:
              $mailMessage->setBody(
                $messageContent,
                $eventFormat->name == NotifierEventFormat::TYPE_HTML ? 'text/html' : 'text/plain'
              );
              break;
            case NotifierEventFormat::PLACE_ATTACHMENT:
              $fileName = $eventFormat->file_name;
              if ($curEventProcess->eventSubscriber->getIsArchiveAttachment()) {
                //TODO Архивируем вложение
              }
              //TODO Добавляем файл в аттач
              break;
          }
        }
        
        if (!$this->onBeforeSend(new NotifierComponentEvent($this, $curEvent, $curEventProcess, $mailMessage))) {
          continue;
        }

        $errorMessage = false;
        try {
          if ($mailer->send($mailMessage, $failures)) {
            $curEventProcess->saveAsSent();
          } else {
            $errorMessage = sprintf("Ошибка при отправке почты:\n %s", print_r($failures, true));
          }
        } catch(Exception $e) {
          $errorMessage = $e->getMessage();
        }
        if ($errorMessage) Yii::log($errorMessage, CLogger::LEVEL_ERROR, 'mail.notifier.send');

      }// endfor $eventProcess
    }// endfor $events
  }
  /**
   * Добавляет новое уведомление
   * @param int $idEventType
   * @param string $message
   * @param int $idEventSubscriber
   * @param array $emails
   * @param int $idInstance
   * @return Notifier
   */
  public function addNewEvent($idEventType, $message, $idEventSubscriber = null, $emails = null, $idInstance = null, $subject = null) {
    $notifierEvent = new NotifierEvent();
    $notifierEvent->id_event_type = $idEventType;
    $notifierEvent->event_message = $message;
    $notifierEvent->setIdEventSubscriber($idEventSubscriber);
    $notifierEvent->setEmails($emails === null ? array() : $emails);
    $notifierEvent->id_instance = $idInstance;
    $notifierEvent->subject = $subject;
    $notifierEvent->save();
    
    $this->setLastAddedEvent($notifierEvent);
    return $this;
  }
  
  /**
   * Отправлет немедленно последнее добавленное уведомление
   */
  public function sendNowLastAdded() {
    $lastAddedEvent = $this->getLastAddedEvent();
    $this->send(array($lastAddedEvent));
    $this->setLastAddedEvent(null);
  }
  
  public function onEmptyMessage(CEvent $event) {
    $this->raiseEvent('onEmptyMessage', $event);
  }
  
  public function onBeforeSend(CEvent $event) {
    $this->raiseEvent('onBeforeSend', $event);
    return $event->isValid;
  }
  
}