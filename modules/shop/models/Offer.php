<?php

/**
 * Модель для таблицы "pr_offer".
 *
 * The followings are the available columns in table 'pr_offer':
 * @property integer $id_offer
 * @property string $fio
 * @property string $phone
 * @property string $mail
 * @property string $comment
 * @property string $ip
 * @property string $offer_text
 * @property integer $create_date
 * @property integer $is_process
 * @property integer $status
 */
class Offer extends DaActiveRecord {
  
  const STATUS_NEW      = 1;
  const STATUS_AGREED   = 2;
  const STATUS_PAYD     = 3;
  const STATUS_DONE     = 4;
  const STATUS_CANCELED = 5;
  
  private $_oldStatus = null;
  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return Offer the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }
  
  public function init() {
    parent::init();
    if ($this->isNewRecord) {
      $this->create_date = time();
      $this->ip = HU::getUserIp();
      $this->is_send = 0;
      $this->status = self::STATUS_NEW;
    }
  }
  
  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'pr_offer';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
      array('fio, mail', 'required'),
      array('fio, phone, mail', 'length', 'max'=>255),
      array('mail', 'email', 'message' => 'Введен некорректный e-mail адрес'),
      array('comment', 'safe'),
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    return array(
      'offerProducts' => array(self::HAS_MANY, 'OfferProduct', 'id_offer'),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
  	return array(
      'id_offer' => 'Id Offer',
      'fio' => 'Имя',
      'phone' => 'Телефон',
      'mail' => 'e-mail',
      'comment' => 'Дополнительный комментарий',
      'offer_text' => 'Текст заявки',
  	  'create_date' => 'Create Date',
      'is_process' => 'Is Process',
    );
  }
  
  protected function afterFind() {
    parent::afterFind();
    $this->_oldStatus = $this->status;
  }
  
  protected function afterSave() {
    parent::afterSave();
    if ($this->isNewRecord) {
      foreach ($this->offerProducts as $offerProduct) {
        $offerProduct->id_offer = $this->getPrimaryKey();
        $offerProduct->save(false);
      }
    }
    //Если нужно произвести списание остатка товара
    if ($this->getNeedDebitProducts()) {
      $this->debitProducts();
    }
    //Если нужно вернуть остаток товара на склад
    if ($this->getNeedCreaditProducts()) {
      $this->creditProducts();
    }
  }
  
  private function isStatusChanged() {
    return $this->_oldStatus != $this->status;
  }
  
  public function getNeedDebitProducts() {
    $daShop = Yii::app()->daShop;
    if ($this->isStatusChanged() && (int)$this->status === $daShop->debitOfferStatus) {
      return true;
    }
    return false;
  }
  
  protected function debitProducts() {
    foreach ($this->offerProducts as $offerProduct) {
      $offerProduct->product->remain -= $offerProduct->amount;
      $offerProduct->product->save(false);
    }
  }
  
  public function getNeedCreaditProducts() {
    $daShop = Yii::app()->daShop;
    if ($this->isStatusChanged() && (int)$this->status === $daShop->creditOfferStatus) {
      return true;
    }
    return false;
  }
  
  protected function creditProducts() {
    foreach ($this->offerProducts as $offerProduct) {
      $offerProduct->product->remain += $offerProduct->amount;
      $offerProduct->product->save(false);
    }
  }

}