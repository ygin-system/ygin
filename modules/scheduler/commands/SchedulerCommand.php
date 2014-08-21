<?php
class SchedulerCommand extends CConsoleCommand {
  /**
   * @var int максимальное количество раз, когда задача может быть завершена ошибочно
   */
  const MAX_COUNT_FAILURES = 10000;
  const ERROR_CODE_LOCK_WAIT_TIMEOUT = 1205;
  
  protected function setIsolationLevel($level) {
    Yii::app()->db
      ->createCommand('SET SESSION TRANSACTION ISOLATION LEVEL '.$level)
      ->execute();
  }
  
  public function log($name, $failures, $errorMessage = null) {
    $msg = "Планировщик {webroot} с задачей {name} не отработал. Ошибок {failures}.";
    $msg = strtr($msg, array(
      '{webroot}' =>  Yii::getPathOfAlias('webroot'),
      '{name}' => $name,
      '{failures}' => $failures,
    ));
    Yii::log($msg, CLogger::LEVEL_ERROR, 'PlanCommand');
  }
  
  /**
   * @return SchedulerJob
   */
  public function createJob(Job $model) {
    Yii::import($model->class_name);
    return Yii::createComponent(array('class' => $model->class_name), $this, $model->id_job);
  }
  
  /**
   * Если вдруг задача выполняется дольше чем положено, то уведомляем.
   */
  public function checkLongExecuted() {
    //Чтобы увидеть дату начала запуска задачи используем грязное чтение данных
    $this->setIsolationLevel('READ UNCOMMITTED');
    $jobs = Job::model()->longExecuted()->findAll();
    $msg = "Планировщик {webroot} с задачей {name}(id: {id}) завис. Время запуска {time}. Ошибок {failures}. Будет сделана попытка перезапустить задачу.";
    foreach ($jobs as $job) {
      /**
       * @var Job $job
       */
      Yii::log(strtr($msg, array(
        '{webroot}' => Yii::getPathOfAlias('webroot'),
        '{name}' => $job->name,
        '{id}' => $job->id_job,
        '{time}' => date('d.m.Y H:i:s', $job->start_date),
        '{failures}' => $job->failures,
      )), CLogger::LEVEL_ERROR, 'PlanCommand');
      $job->start_date = null;
      $job->update(array('start_date'));
    }
  }
  
  public function actionIndex($args = array()) {
    Yii::app()->db->createCommand('SET AUTOCOMMIT=0')->execute();
    $this->checkLongExecuted();
    
    //READ COMMITTED отличается от изоляции по умолчанию (REPEATABLE READ), тем,
    //что в REPEATABLE READ второй селект вернёт данные те же что и в первом (не смотря на то,
    //что данные были закоммичены первой транзакцией ),
    //т.е. у REPEATABLE READ полная согласованноть чтения данных
    $this->setIsolationLevel('READ COMMITTED');
    
    $candidateCriteria = new CDbCriteria(array('order' => 't.priority DESC, RAND()'));
    $db = Yii::app()->db;
    $c = 0;
    $time = time();
    while(1) {
      $transaction = $db->beginTransaction();
      try {
        $curJob = Job::model()
          ->resetScope()
          ->available(self::MAX_COUNT_FAILURES, $time)
          ->find($candidateCriteria);
        //Нет задач, выходим
        if ($curJob === null) break;
      } catch (CDbException $e) {
        //Если запись залочена другой транзакцией, то пропускаем
        if ($e->getCode() == self::ERROR_CODE_LOCK_WAIT_TIMEOUT) {
          $transaction->rollback();
          $candidateCriteria->addCondition('t.id_job != '.$curJob->id_job);
          continue;
        }
        throw $e;
      }
      //Если время выполнения задачи еще не подошло, то пропускаем
      if (!$curJob->getExecutionTimeHasCome($time)) {
        $transaction->rollback();
        continue;
      }
      //Если достигли максимального количества ошибок, исключаем эту задачу
      if ($curJob->failures == self::MAX_COUNT_FAILURES) {
        $transaction->rollback();
        $candidateCriteria->addCondition('t.id_job != '.$curJob->id_job);
        $this->log($curJob->name, $curJob->failures);
        continue;
      } elseif ($curJob->failures == 1) {
        $this->log($curJob->name, $curJob->failures);
      }
      
      //Увеличиваем счетчик ошибок и сохраняем
      //для того чтобы, если скрипт задачи упадет,
      //то при следующем запуске планировщика мы об этом узнаем
      /*if ($curJob->is_null_start_date) {
        $curJob->start_date = null;
      } else {
        $curJob->start_date = time();
      }*/
      $curJob->failures++;
      $curJob->save(false);
      $transaction->commit();
      $this->setIsolationLevel('REPEATABLE READ');
      
      //Создаем и запускаем задачу
      $schedulerJob = $this->createJob($curJob);
      if (!($schedulerJob instanceof SchedulerJob)) {
        throw new ErrorException('Класс задачи '.$curJob->name.' '.get_class($schedulerJob).' должен расширять класс SchedulerJob.');
      }
      $result = (int)$schedulerJob->run();
      
      $this->setIsolationLevel('READ COMMITTED');
      $interval = $curJob->interval_value;
      //Если вернулся код ошибки
      if ($result !== SchedulerJob::RESULT_OK) {
        $interval = $curJob->error_repeat_interval;
      } else {
        $curJob->failures = 0;
      }
      
      $curJob->last_start_date = $curJob->next_start_date;
      $curJob->next_start_date += $interval;
      
      if ($curJob->next_start_date < $time) {
        $newDate = HDate::getTimestampOnBeginning($time, HDate::BEGINNING_DAY);
        
        $timeParts = getdate($curJob->next_start_date);
        $newDate += $timeParts['hours'] * 3600 + $timeParts['minutes'] * 60 + $timeParts['seconds'];
        
        if (($newDate - $interval) > $time) {
          $step = floor(($newDate-$time)/$interval);
          $newDate = $newDate - $step * $interval;
        }
        
        if ($newDate < $time) {
          $step = floor(($time - $newDate)/$interval) + 1;
          $newDate = $newDate + $step * $interval;
        }
        
        $curJob->last_start_date = $time;
        $curJob->next_start_date = $newDate;
      }
      //сохраняем задачу
      $transaction = $db->beginTransaction();
      if (empty($curJob->first_start_date)) {
        $curJob->first_start_date = $curJob->last_start_date;
      }
      $curJob->start_date = null;
      $curJob->save(false);
      $transaction->commit();
    }
  }
}