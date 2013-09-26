<?php

/**
 * Модель для таблицы "da_job".
 *
 * The followings are the available columns in table 'da_job':
 * @property integer $id_job
 * @property integer $interval_value
 * @property integer $error_repeat_interval
 * @property integer $first_start_date
 * @property integer $last_start_date
 * @property integer $next_start_date
 * @property integer $failures
 * @property string $name
 * @property string $class_name
 * @property integer $active
 * @property integer $priority
 * @property integer $start_date
 * @property integer $max_second_process
 */
class Job extends DaActiveRecord {

  const ID_OBJECT = 51;
  protected $idObject = self::ID_OBJECT;

  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return Job the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'da_job';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
      array('id_job', 'match', 'pattern'=>'~\d+|[a-zA-Z\d\_]+\-[a-zA-Z\d\_\-]*[a-zA-Z\d\_]+~', 'message'=>'ИД должен содержать дефис'),
      array('id_job', 'unique'),
      array('name, class_name, id_job', 'required'),
      array('interval_value, error_repeat_interval, first_start_date, last_start_date, next_start_date, failures, active, priority, start_date, max_second_process', 'numerical', 'integerOnly'=>true),
      array('id_job, name, class_name', 'length', 'max'=>255),
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    return array(
    );
  }
  
  public function scopes() {
    $a = $this->tableAlias;
    return array(
      'longExecuted' => array(
        'condition' => "$a.max_second_process IS NOT NULL AND $a.max_second_process > 0 AND (start_date + max_second_process) < ".time(),
      ),
    );
  }
  
  public function available($maxFailures, $time) {
    $a = $this->tableAlias;
    $this->dbCriteria->mergeWith(array(
      'condition' => "$a.start_date IS NULL AND $a.active=1 AND $a.failures < :FAILURES
                      AND ($a.next_start_date IS NULL OR $a.next_start_date < :TIME)",
      'params' => array(':FAILURES' => $maxFailures, ':TIME' => $time),
    ));
    return $this;
  }
  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
      'id_job' => 'Id Job',
      'interval_value' => 'Interval Value',
      'error_repeat_interval' => 'Error Repeat Interval',
      'first_start_date' => 'First Start Date',
      'last_start_date' => 'Last Start Date',
      'next_start_date' => 'Next Start Date',
      'failures' => 'Failures',
      'name' => 'Name',
      'class_name' => 'Class Name',
      'active' => 'Active',
      'priority' => 'Priority',
      'start_date' => 'Start Date',
      'max_second_process' => 'Max Second Process',
    );
  }
  
  public function getExecutionTimeHasCome($curTime) {
    return empty($this->next_start_date) || (!empty($this->next_start_date) && $this->next_start_date <= $curTime);
  }

}