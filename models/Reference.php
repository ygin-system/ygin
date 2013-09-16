<?php

/**
 * Модель для таблицы "da_references".
 *
 * The followings are the available columns in table 'da_references':
 * @property integer $id_reference
 * @property string $name
 */
class Reference extends DaActiveRecord {

  const ID_OBJECT = 27;
  protected $idObject = self::ID_OBJECT;

  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return Reference the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'da_references';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
      array('id_reference', 'match', 'pattern'=>'~\d+|[a-zA-Z\d\_]+\-[a-zA-Z\d\_\-]*[a-zA-Z\d\_]+~', 'message'=>'ИД должен содержать дефис'),
      array('id_reference', 'unique'),
      array('name, id_reference', 'required'),
      array('name, id_reference', 'length', 'max'=>100),
    );
  }

  protected function afterSave() {
    if (!$this->isNewRecord) {
      $idOldReference = $this->getPkBeforeSave();
      if ($this->id_reference != $idOldReference) {
        ReferenceElement::model()->updateAll(array('id_reference'=>$this->id_reference), 'id_reference=:id', array(':id' => $idOldReference));
        ObjectParameter::model()->updateAll(array('add_parameter'=>$this->id_reference), 'id_parameter_type=6 AND add_parameter=:id', array(':id' => $idOldReference));
      }
    }
    return parent::afterSave();
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
      'id_reference' => 'Id Reference',
      'name' => 'Name',
    );
  }

}