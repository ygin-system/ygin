<?php
/**
 * Модель для таблицы "da_reference_element".
 *
 * The followings are the available columns in table 'da_reference_element':
 * @property integer $id_reference
 * @property integer $id_reference_element
 * @property string $value
 * @property string $image_element
 * @property integer $id_reference_element_instance
 */
class ReferenceElement extends DaActiveRecord {

  const ID_OBJECT = 28;
  protected $idObject = self::ID_OBJECT;

  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return ReferenceElement the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  public function getIdReference() {
    return $this->id_reference;
  }
  public function getIdReferenceElement() {
    return $this->id_reference_element;
  }
  public function getValue() {
    return $this->value;
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'da_reference_element';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
      array('value', 'required'),
      array('id_reference_element', 'numerical', 'integerOnly'=>true),
      array('id_reference_element_instance, id_reference, value', 'length', 'max'=>255),
      array('image_element', 'length', 'max'=>150),

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
    $criteria = new CDbCriteria(array(
      'order' => $alias.'.id_reference_element',
    ));
    return $criteria->toArray();
  }
  public function byReferenceElement($idReference, $idReferenceElement) {
    $this->getDbCriteria()->mergeWith(array(
      'condition' => $this->getTableAlias().'.id_reference=:ref AND '.$this->getTableAlias().'.id_reference_element=:element',
      'params' => array(':ref' => $idReference, ':element' => $idReferenceElement),
    ));
    return $this;
  }
  public function byReference($idReference) {
    $this->getDbCriteria()->mergeWith(array(
      'condition' => $this->getTableAlias().'.id_reference=:ref',
      'params' => array(':ref' => $idReference),
    ));
    return $this;
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
      'id_reference' => 'Id Reference',
      'id_reference_element' => 'Id Reference Element',
      'value' => 'Value',
      'image_element' => 'Image Element',
      'id_reference_element_instance' => 'Id Reference Element Instance',
    );
  }

}