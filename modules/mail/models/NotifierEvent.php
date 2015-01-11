<?php

/**
 * This is the model class for table "da_event".
 *
 * The followings are the available columns in table 'da_event':
 * @property integer $id_instance
 * @property integer $id_event
 * @property integer $id_event_type
 * @property string $event_message
 * @property integer $event_create
 */
class NotifierEvent extends DaActiveRecord
{
  const ID_OBJECT = 49;
  
  protected $idObject = self::ID_OBJECT;
  
  private $_idEventSubscriber = null;
  private $_emails = array();
  
  private $_recipientsEmails = array();
  /**
   * Массив получателей уведомлений
   * @var array NotifierEventProcess
   */
  private $_eventsProcess = null;
  
  
  
  private static $_cache = array();
  /**
   * Кешировать email'ы подписчиков
   * @var boolean
   */
  private static $_cacheSubscribersEmails = false;

  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return NotifierEvent the static model class
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }
  
  public static function setCacheSubscribersEmails($cache) {
    self::$_cacheSubscribersEmails = $cache;
  }
  
  public static function getCacheSubscribersEmails() {
    return self::$_cacheSubscribersEmails;
  }
  
  protected static function setCache($key, $data) {
    self::$_cache[$key] = $data;
  }
  
  protected static function getCache($key) {
    if (!array_key_exists($key, self::$_cache)) {
      return false;
    }
    return self::$_cache[$key];
  }
  
  public function getIdEventSubscriber() {
    return $this->_idEventSubscriber;
  }
  public function setIdEventSubscriber($idEventSubscriber) {
    $this->_idEventSubscriber = $idEventSubscriber;
  }
  public function getEmails() {
    return $this->_emails;
  }
  public function setEmails($emails) {
    $this->_emails = array_values(array_unique((array)$emails));
    $emailValidator = new CEmailValidator();
    foreach ($this->_emails as $email) {
      if (!$emailValidator->validateValue($email)) {
        throw new CException('Некорректный e-mail '.$email);
      }
    }
  }

  public function getEventsProcess() {
    if ($this->_eventsProcess === null) {
      $this->_eventsProcess = NotifierEventProcess::model()->scForSend()->findAll(
        't.id_event = :ID_EVENT', array(':ID_EVENT' => $this->primaryKey
      ));
    }
    return $this->_eventsProcess;
  }
  
  private function setEventsProcess(array $eventsProcess) {
    $this->_eventsProcess = $eventsProcess;
  }
  
  private function addEventProcess(NotifierEventProcess $eventProcess) {
    if ($this->_eventsProcess === null) {
      $this->_eventsProcess = array();
    }
    $this->_eventsProcess[] = $eventProcess;
  }
  
  /**
   * @return string the associated database table name
   */
  public function tableName()
  {
    return 'da_event';
  }
  
  /**
   * @return array validation rules for model attributes.
   */
  public function rules()
  {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
      array('id_instance, id_event, id_event_type, event_create', 'numerical', 'integerOnly'=>true),
      array('event_message', 'safe'),
      array('subject', 'length', 'max' => 255)
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    return array(
      'eventProcess' => array(self::HAS_MANY, 'NotifierEventProcess', 'id_event', 'joinType' => 'INNER JOIN'),
      'eventType' => array(self::BELONGS_TO, 'NotifierEventType', 'id_event_type', 'joinType' => 'INNER JOIN'),
    );
  }
    
    public function behaviors() {
      return array(
        'CascadeDelete' => array(
          'class' => 'CascadeDeleteBehavior',
          'relations' => array(
            'eventProcess',
          ),
        ),
      );
    }
    

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels()
  {
    return array(
      'id_instance' => 'Id Instance',
      'id_event' => 'Id Event',
      'id_event_type' => 'Id Event Type',
      'event_message' => 'Event Message',
      'event_create' => 'Event Create',
      'subject' => 'Subject'
    );
  }

  
  /**
   * Получает подписчиков и их email'ы
   * @return array of array - масив, где в качестве ключей выступают ид подписчиков, а в качестве значений массив emails
   */
  protected function getRecipientsEmails() {
    if (empty($this->id_event_type)) {
      throw new CException('Не указан id_event_type');
    }
    
    $emails = array();
    //если есть ид подписчика и указаны email'ы то рассылаем на них
    if (!empty($this->idEventSubscriber) && !empty($this->emails)) {
      $emails[$this->idEventSubscriber] = $this->emails;
    } else {
      
      $criteria = new CDbCriteria(array(
        'select' => '*',
        'condition' => 'id_event_type = :ID_EVENT_TYPE',
        'params' => array(':ID_EVENT_TYPE' => $this->id_event_type),
      ));
      
      //Если указан, то делаем уточнение по данному подписчику
      if (!empty($this->idEventSubscriber)) {
        $criteria->addCondition('id_event_subscriber = :ID_EVENT_SUBSCR');
        $criteria->params[':ID_EVENT_SUBSCR'] = $this->idEventSubscriber;
      }
      $emails = array();
      $cacheKey = '';
      if (self::getCacheSubscribersEmails()) {
        $cacheKey = md5(serialize($criteria));
        $emails = self::getCache($cacheKey);
      }
      if (!self::getCacheSubscribersEmails() || $emails === false) {
        $emails = array();
        $dataReader = $this->getDbConnection()
                           ->commandBuilder
                           ->createFindCommand('da_event_subscriber', $criteria)
                           ->query();
        //Собираем email'ы подписчиков
        foreach ($dataReader as $row) {
          $criteria = new CDbCriteria(array('select' => 'mail'));
          
          if ($row['id_user'] !== null) {
            $criteria->addCondition('id_user=:idUser');
            $criteria->params[':idUser'] = $row['id_user'];
          }
//          if ($row['id_group'] !== null) {
//            $criteria->addCondition('id_group = :idGroup', 'OR');
//            $criteria->params[':idGroup'] = $row['id_group'];
//          }
          
          $draftEmails = array();
//          if ($row['id_user'] !== null || $row['id_group'] !== null) {
          if ($row['id_user'] !== null) {
            $criteria->addCondition('mail IS NOT NULL AND mail <> ""', 'AND');
            $command = $this->getDbConnection()->commandBuilder->createFindCommand('da_users', $criteria);
            $draftEmails = $command->queryColumn();
          }
          
          if ($row['email'] !== null) {
            array_push($draftEmails, $row['email']);
          }
          $emails[$row['id_event_subscriber']] = array_values(array_unique($draftEmails));
        }
        $dataReader->close();
      }
      //еслин нужно кешировать, то заносим данные в кеш
      if (self::getCacheSubscribersEmails()) {
        self::setCache($cacheKey, $emails);
      }
    }
    
    //Если указан id_instance, то надо убрать из списка рассылки email'ы,
    //на которые еще не были отправлены уведомления
    if (!empty($this->id_instance)) {
      $sql = "SELECT DISTINCT a.email
                FROM da_event_process a
                JOIN da_event b
                  ON a.id_event=b.id_event
               WHERE b.id_instance=:ID_INST
                     AND b.id_event_type=:ID_EVENT_TYPE
                     AND a.notify_date IS NULL
                     AND a.id_event_subscriber=:ID_EVENT_SUBSCR";
      $command = $this->getDbConnection()->createCommand($sql);
      foreach ($emails as $idSubscriber => $subscrEmails) {
        $unnotifiedEmails = $command->queryColumn(array(
          ':ID_INST' => $this->id_instance,
          ':ID_EVENT_TYPE' => $this->id_event_type,
          ':ID_EVENT_SUBSCR' => $idSubscriber,
        ));
        $emails[$idSubscriber] = array_diff($subscrEmails, $unnotifiedEmails);
      }
    }
    return $emails;
  }
  
  protected function beforeSave() {
    if (!parent::beforeSave()) {
      return false;
    }
    
    if ($this->getIsNewRecord()) {
      if (empty($this->id_instance)) {
        if (empty($this->event_message)) {
          throw new CException('Не указан текст уведомления');
        }
      } else {
        if ($this->event_message === '') {
          $this->event_message = null;
        }
      }
      $this->_recipientsEmails = $this->getRecipientsEmails();
      if (empty($this->_recipientsEmails)) {
        return;
      }
      $this->event_create = time();
    }
    return true;
  }
  
  protected function addNotifyingToQueue() {
    $command = Yii::app()->db->createCommand(
      'INSERT INTO da_event_process(id_event, email, id_event_subscriber, notify_date) VALUES(?,?,?,?)'
    );
    foreach ($this->_recipientsEmails as $idEventSubscriber => $emails) {
      $ec = count($emails);
      for($i = 0; $i < $ec; $i++) {
        $command->execute(array($this->getPrimaryKey(), $emails[$i], $idEventSubscriber, null));
      }
    }
  }
  
  protected function afterSave() {
    if ($this->getIsNewRecord()) {
      $this->addNotifyingToQueue();
    }
  }
  
  /*protected function beforeDelete() {
    if (!parent::beforeDelete()) {
      return false;
    }
    $this->getDbConnection()
      ->createCommand('DELETE FROM da_event_process WHERE id_event = :ID_EVENT')
      ->execute(array(':ID_EVENT' => $this->getPrimaryKey()));
    return true;
  }*/
  
  public function getForSend($count = null) {
    $criteria = new CDbCriteria();
    $criteria->order = 'eventType.id_object, notifierEvent.id_instance, eventSubscriber.format';
    if (!empty($count)) {
      $criteria->limit = $count;
    }
    //из-за использования ограничения на количество записей
    //нужно получить получателей (da_event_process),
    //а не события с получателями, инначе рассылка будет происходить в не той последовательности
    //в какой добавлены были письма
    $eventsProcess = NotifierEventProcess::model()->scForSend()->findAll($criteria);
    $result = array();
    $c = count($eventsProcess);
    //группируем получателей по событию
    for ($i = 0; $i < $c; $i++) {
      $curNotifierEventProcess = $eventsProcess[$i];
      $curNotifierEvent = $curNotifierEventProcess->notifierEvent;
      $c2 = count($result);
      $findIndex = false;
      for ($j = 0; $j < $c2; $j++) {
        if ($result[$j] === $curNotifierEvent) {
          $findIndex = $j;
          break;
        }
      }
      if ($findIndex !== false) {
        $result[$findIndex]->addEventProcess($curNotifierEventProcess);
      } else {
        $curNotifierEvent->addEventProcess($curNotifierEventProcess);
        $result[] = $curNotifierEvent;
      }
    }
    return $result;
  }
}