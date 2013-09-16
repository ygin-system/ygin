<?php
/**
 * Модель для таблицы "da_object_view".
 *
 * The followings are the available columns in table 'da_object_view':
 * @property integer $id_object_view
 * @property integer $id_object
 * @property string $name
 * @property integer $order_no
 * @property integer $visible
 * @property string $sql_select
 * @property string $sql_from
 * @property string $sql_where
 * @property string $sql_order_by
 * @property integer $count_data
 * @property string $icon_class
 * @property string $id_parent
 */
class DaObjectView extends DaActiveRecord {
  
  const ID_OBJECT = 63;
  protected $idObject = self::ID_OBJECT;

  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return DaObjectView the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  public function getWhere() {
    return ($this->sql_where === null ? '' : $this->sql_where);
  }
  public function getCountData() {
    $res = $this->count_data;
    if ($res === null || !is_numeric($res)) $res = 50;
    return $res;
  }
  public function getOrderBy() {
    return $this->sql_order_by;
  }
  public function getSelect() {
    return $this->sql_select;
  }
  public function getName() {
    return $this->name;
  }




  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'da_object_view';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
      array('id_object_view', 'match', 'pattern'=>'~\d+|[a-zA-Z\d\_]+\-[a-zA-Z\d\_\-]*[a-zA-Z\d\_]+~', 'message'=>'ИД должен содержать дефис'),
      array('id_object_view', 'unique'),
      array('id_object_view, id_object, name', 'required'),
      array('order_no, visible, count_data', 'numerical', 'integerOnly'=>true),
      array('id_object_view, id_object, name, sql_select, sql_from, sql_where, sql_order_by, icon_class', 'length', 'max'=>255),
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    return array(
      'object' => array(self::BELONGS_TO, 'DaObject', 'id_object', 'joinType' => 'INNER JOIN',),
      'columns' => array(self::HAS_MANY, 'DaObjectViewColumn', 'id_object_view', 'order'=>'columns.order_no ASC',),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
      'id_object_view' => 'Id Object View',
      'id_object' => 'Id Object',
      'name' => 'Name',
      'order_no' => 'Order No',
      'visible' => 'Visible',
      'sql_select' => 'Sql Select',
      'sql_from' => 'Sql From',
      'sql_where' => 'Sql Where',
      'sql_order_by' => 'Sql Order By',
      'count_data' => 'Count Data',
      'icon_class' => 'Icon Class',
    );
  }

  protected function afterSave() {
    if (!$this->isNewRecord) {
      $idOldView = $this->getPkBeforeSave();
      if ($this->id_object_view != $idOldView) {
        DaObjectViewColumn::model()->updateAll(array('id_object_view'=>$this->id_object_view), 'id_object_view=:view', array(':view' => $idOldView));
      }
    }
    return parent::afterSave();
  }
    
  public function selectName() {
    $alias = $this->getTableAlias();
    $this->getDbCriteria()->mergeWith(array(
        'select' => $alias.'.name, '.$alias.'.icon_class, '.$alias.'.id_object_view',
    ));
    return $this;
  }

}