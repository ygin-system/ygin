<?php

/**
 * This is the model class for table "pr_voting_answer".
 *
 * The followings are the available columns in table 'pr_voting_answer':
 * @property integer $id_voting_answer
 * @property integer $id_voting
 * @property string $name
 * @property integer $count
 */
class VotingAnswer extends DaActiveRecord
{
	const ID_OBJECT = 106;
	protected $idObject = self::ID_OBJECT;
  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return DaVotingAnswer the static model class
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
    return 'pr_voting_answer';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules()
  {
    return array(
      array('name', 'required'),
      array('id_voting, count', 'numerical', 'integerOnly'=>true),
      array('name', 'length', 'max'=>60),
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations()
  {
    // NOTE: you may need to adjust the relation name and the related
    // class name for the relations automatically generated below.
    return array(
      'question'=>array(self::BELONGS_TO, 'Voting', 'id_voting'),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels()
  {
    return array(
      'id_voting_answer' => 'Id Voting Answer',
      'id_voting' => 'Id Voting',
      'name' => 'Name',
      'count' => 'Count',
    );
  }

}