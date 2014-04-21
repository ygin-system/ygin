<?php

/**
 * Модель для таблицы "pr_invoice".
 *
 * The followings are the available columns in table 'pr_invoice':
 * @property integer $id_invoice
 * @property string $create_date
 * @property string $pay_date
 * @property integer $amount
 * @property integer $id_offer
 */
class Invoice extends DaActiveRecord {

  const ID_OBJECT = 'ygin-invoice';

  protected $idObject = self::ID_OBJECT;

  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return Invoice the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'pr_invoice';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    return array(
      'offer' => array(self::BELONGS_TO, 'Offer', 'id_offer'),
    );
  }

  public function scopes() {
    $a = $this->tableAlias;
    return array(
      'done' => array('condition' => "$a.pay_date IS NOT NULL"),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
      'id_invoice' => 'Id Invoice',
      'create_date' => 'Create Date',
      'pay_date' => 'Pay date',
      'amount' => 'Amount',
      'id_offer' => 'Id Offer',
    );
  }

}
