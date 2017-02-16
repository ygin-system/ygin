<?php

/**
 * Модель для таблицы "da_instruction".
 *
 * The followings are the available columns in table 'da_instruction':
 * @property integer $id_instruction
 * @property string $name
 * @property string $content
 * @property integer $desc_type
 * @property integer $visible
 * @property integer $num_seq
 */
class Instruction extends DaActiveRecord {
  
  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return Instruction the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'da_instruction';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
      array('id_instruction, name, content', 'required'),
      array('id_instruction, desc_type, visible, num_seq', 'numerical', 'integerOnly'=>true),
      array('name', 'length', 'max'=>255),

    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    return array(
    );
  }

  public function defaultScope() {
    $alias = $this->getTableAlias(true, false);
    return array(
        'condition' => $alias.".visible = 1",
        'order' => $alias.".num_seq",
    );
  }
  
  public function getUrl() {
    if (!$this->isNewRecord) {
      return Yii::app()->createUrl('instruction', array('id' => $this->id_instruction));
    }
    return '/';
  }


  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
      'id_instruction' => 'Id Instruction',
      'name' => 'Name',
      'content' => 'Content',
      'desc_type' => 'Desc Type',
      'visible' => 'Visible',
      'num_seq' => 'Num Seq',
    );
  }

}