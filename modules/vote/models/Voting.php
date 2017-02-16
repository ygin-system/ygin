<?php

/**
 * This is the model class for table "pr_voting".
 *
 * The followings are the available columns in table 'pr_voting':
 * @property integer $id_voting
 * @property string $name
 * @property integer $create_date
 * @property integer $is_active
 * @property integer $is_checkbox
 * @property integer $in_module
 */
class Voting extends DaActiveRecord {
  
  const ID_OBJECT = 105;
  protected $idObject = self::ID_OBJECT;

  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return Voting the static model class
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }
  
  /**
   * @return string the associated database table name
   */
  public function tableName()
  {
    return 'pr_voting';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
      array('name', 'required'),
      array('create_date, is_active, is_checkbox, in_module', 'numerical', 'integerOnly'=>true),
      array('name', 'length', 'max'=>60),
    );
  }
  
  
  
  public function inModule() {
    $criteria = new CDbCriteria();
    $criteria->addColumnCondition(array('in_module' => '1'));
    //$criteria->order = 'RAND('.$this->getTableAlias().'.id_voting)';
    $this->getDbCriteria()->mergeWith($criteria);
    return $this;
  }
  public function onlyActive($order=null) {
    $criteria = new CDbCriteria();
    $criteria->addColumnCondition(array('is_active' => '1'));
    if ($order != null) $criteria->order = $order;
    
    $this->getDbCriteria()->mergeWith($criteria);
    return $this;
  }
  
  public function getSumVote() {
    $answers = $this->answer;
    $c = 0;
    foreach ($answers AS $ans) {
      $c += $ans->count;
    }
    return $c;
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    return array(
      'answer'=>array(self::HAS_MANY, 'VotingAnswer', 'id_voting', 'joinType' => 'JOIN', 'order' => 'answer.id_voting, answer.id_voting_answer'),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels()
  {
    return array(
      'id_voting' => '№ вопроса',
      'name' => 'Вопрос',
      'create_date' => 'Дата создания',
      'is_active' => 'Статус',
      'is_checkbox' => 'Множественный ответ',
      'in_module' => 'Отображать в модуле',
    );
  }
  
}