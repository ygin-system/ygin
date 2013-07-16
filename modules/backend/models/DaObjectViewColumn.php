<?php

/**
 * Модель для таблицы "da_object_view_column".
 *
 * The followings are the available columns in table 'da_object_view_column':
 * @property integer $id_object_view_column
 * @property integer $id_object_view
 * @property integer $id_object
 * @property string $caption
 * @property integer $order_no
 * @property integer $id_object_parameter
 * @property integer $id_data_type
 * @property string $field_name
 * @property integer $handler
 * @property integer $visible
 */
class DaObjectViewColumn extends DaActiveRecord {

  const ID_OBJECT = 66;
  protected $idObject = self::ID_OBJECT;

  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return DaObjectViewColumn the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'da_object_view_column';
  }

  public function getType() {
    return $this->id_data_type;
  }
  public function getIdObjectParameter() {
    return $this->id_object_parameter;
  }
  public function getIdColumn() {
    return $this->id_object_view_column;
  }
  public function getField() {
    return $this->field_name;
  }
  public function getCaption() {
    return $this->caption;
  }
  public function getIdPhpScript() {
    return $this->handler;
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
      array('id_object_view_column', 'match', 'pattern'=>'~\d+|[a-zA-Z\d\_]+\-[a-zA-Z\d\_\-]*[a-zA-Z\d\_]+~', 'message'=>'ИД должен содержать дефис'),
      array('id_object_view, id_object_view_column, id_object, field_name', 'required'),
      array('order_no, id_data_type, visible', 'numerical', 'integerOnly'=>true),
      array('handler, id_object_view_column, id_object_view, id_object_parameter, id_object, caption, field_name', 'length', 'max'=>255),
    );
  }

  public function onlyVisible() {
    $this->getDbCriteria()->mergeWith(array(
      'condition' => $this->getTableAlias().'.visible=1',
    ));
    return $this;
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    return array(
      'columnClass' => array(self::BELONGS_TO, 'PhpScript', 'handler'),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
      'id_object_view_column' => 'Id Object View Column',
      'id_object_view' => 'Id Object View',
      'id_object' => 'Id Object',
      'caption' => 'Caption',
      'order_no' => 'Order No',
      'id_object_parameter' => 'Id Object Parameter',
      'id_data_type' => 'Id Data Type',
      'field_name' => 'Field Name',
      'handler' => 'Handler',
      'visible' => 'Visible',
    );
  }

}