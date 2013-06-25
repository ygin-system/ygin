<?php

/**
 * Модель для таблицы "da_search_history".
 *
 * The followings are the available columns in table 'da_search_history':
 * @property integer $id_search_history
 * @property string $phrase
 * @property string $query
 * @property string $info
 * @property integer $date
 * @property string $ip
 */
class SearchHistory extends DaActiveRecord
 {
  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return SearchHistory the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'da_search_history';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
      array('date, ip', 'required'),
      array('id_search_history, date', 'numerical', 'integerOnly'=>true),
      array('phrase, info', 'length', 'max'=>255),
      array('ip', 'length', 'max'=>32),
      array('query', 'safe'),
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    return array(
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
      'id_search_history' => 'Id Search History',
      'phrase' => 'Phrase',
      'query' => 'Query',
      'info' => 'Info',
      'date' => 'Date',
      'ip' => 'Ip',
    );
  }

}