<?php

/**
 * Модель для таблицы "da_object".
 *
 * The followings are the available columns in table 'da_object':
 * @property integer $id_object
 * @property string $name
 * @property integer $id_field_order
 * @property integer $order_type
 * @property string $table_name
 * @property integer $id_field_caption
 * @property integer $object_type
 * @property string $folder_name
 * @property integer $parent_object
 * @property integer $sequence
 * @property integer $use_domain_isolation
 * @property string $field_caption
 * @property string $yii_model
 */
class DaObject extends DaActiveRecord {
  
  const OBJECT_TYPE_TABLE = 1;
  const OBJECT_TYPE_CONTROLLER = 3;
  const OBJECT_TYPE_LINK = 5;

  private static $_objects = array();

  private $_isEventHandlerRegister = false;

  const ID_OBJECT = 20;
  protected $idObject = self::ID_OBJECT;

  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return Object the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'da_object';
  }

  public function getName() {
    return $this->name;
  }

  public function getOrderBy() {
    $order = '';
    if ($this->id_field_order != null) {
      $parameter = $this->getParameterObjectByIdParameter($this->id_field_order);
      if ($parameter != null) {
        $order = $parameter->getFieldName();
        if ($this->order_type == 2) $order .= ' DESC';
      }
    }
    return $order;
  }

  public function getFolderName() {
    return $this->folder_name;
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
      array('parent_object, id_object', 'match', 'pattern'=>'~\d+|[a-zA-Z\d\_]+\-[a-zA-Z\d\_\-]*[a-zA-Z\d\_]+~', 'message'=>'ИД объекта должен содержать дефис'),
      array('name, id_object', 'required'),
      array('id_object', 'unique'),
      array('parent_object', 'default', 'setOnEmpty' => true, 'value' => null),
      array('order_type, object_type, sequence, use_domain_isolation', 'numerical', 'integerOnly'=>true),
      array('id_field_caption, id_field_order, id_object, name, table_name, folder_name, yii_model', 'length', 'max'=>255),
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    return array(
        'child' => array(self::HAS_MANY, 'DaObject', 'parent_object', 'scopes' => 'orderBySeq' ), //'order' => 'child.sequence ASC'
        'countChild' => array(self::STAT, 'DaObject', 'parent_object'),
        'views' => array(self::HAS_MANY, 'DaObjectView', 'id_object', 'order' => 'views.order_no ASC', 'on' => 'views.visible=1',),
        'parameters' => array(self::HAS_MANY, 'ObjectParameter', 'id_object', 'order' => 'parameters.is_additional ASC, parameters.sequence ASC',),
        'relationParameters' => array(self::HAS_MANY, 'ObjectParameter', 'add_parameter', 'condition'=>'relationParameters.id_parameter_type='.DataType::OBJECT, 'order' => 'relationParameters.id_object',), // "($add OR add_parameter=".$obj->getIdParentObject().")";
    );
  }
  
  public function orderBySeq() {
    $this->getDbCriteria()->mergeWith(array(
        'order' => $this->getTableAlias().'.sequence ASC',
    ));
    return $this;
  }

  /**
   * @return DaActiveRecord
   */
  public function getModel($newModel=false) {
    if ($this->yii_model != null) {
      $classModel = Yii::import($this->yii_model, true);
      $model = ($newModel ? self::newModel($classModel) : self::model($classModel));
      /**
       * @var $model DaActiveRecord
       */
      $model->setObjectInstance($this);
      $model->resetScope();
      return $model;
    }
    return DaInstance::forObject($this);
  }

  /**
   * @param string $fieldName имя поля
   * @return ObjectParameter
   */
  public function getParameterObjectByField($fieldName) {
    if ($fieldName == null) return null;
    $params = $this->parameters;
    foreach($params AS $p) {
      if ($p->getFieldName() == $fieldName) {
        return $p;
      }
    }
    return null;
  }

  /**
   * @param $idParameter
   * @return ObjectParameter
   */
  public function getParameterObjectByIdParameter($idParameter) {
    $params = $this->parameters;
    foreach($params AS $p) {
      if ($p->getIdParameter() == $idParameter) {
        return $p;
      }
    }
    return null;
  }

  public function getFieldCaption() {
    return $this->field_caption;
  }

  /**
   * @static
   * @param $idObject
   * @param bool $loadWithParameter
   * @return DaObject
   */
  public static function getById($idObject, $loadWithParameter=true) {
    // TODO должен быть единым методом по получению объекта
    // в будущем возможно реализовать кэширование и тд
    if ($loadWithParameter) {
      return DaObject::model()->cache(3600)->with('parameters')->findByPk($idObject);
    }
    if (!isset(self::$_objects[$idObject])) {
      self::$_objects[$idObject] = DaObject::model()->cache(3600)->findByPk($idObject);
    }
    return self::$_objects[$idObject];
  }

  public function registerYiiEventHandler($controller = null) {
    if ($this->_isEventHandlerRegister) return;
    if ($controller == null) $controller = Yii::app()->controller;
    $config = $this->getModel()->getBackendEventHandler();
    if (!isset($config['class'])) $config['class'] = 'BackendEventHandler';
    Yii::createComponent($config, $controller, $this->id_object);
    $this->_isEventHandlerRegister = true;
  }

  public function getFieldByType($type, $all=false) {
    $params = $this->parameters;
    $result = array();
    foreach($params AS $p) {
      if ($p->getType() == $type) {
        if ($all) $result[] = $p->getFieldName();
          else return $p->getFieldName();
      }
    }
    return ($all ? $result : null);
  }

  public function isProcessDeleteChild() {
    return false;
  }

  public function getCreateTableSql($html = false) {
    $sql = "";
    if ($this->id_object != null && $this->table_name != null && $this->object_type != self::OBJECT_TYPE_CONTROLLER) {
      // Сооружаем sql-запрос
      $props = $this->parameters;
      $primary = '';
      $text_sql = array();
      foreach($props AS $prop) {
        $type = $prop->getType();
        $name = $prop->getFieldName();

        $type_var = DataType::getSqlType($type);
        if ($type_var == null) continue;

        $null = ($prop->isRequired()) ? "NOT NULL" : "NULL";
        $default = "";
        if ($prop->getDefaultValue() != null) {
          $default = "default '".$prop->getDefaultValue()."'";
        }

        if ($type == DataType::PRIMARY_KEY) {
          $primary = "PRIMARY KEY(`".$name."`)";
          $default .= ' AUTO_INCREMENT';
        }

        $text_sql[] = trim("`".$name."` ".$type_var." ".$null." ".$default);
      }

      if (count($text_sql)) {
        $table = $this->table_name;
        if (is_numeric($table)) {
          $obParent = DaObject::getById($table);
          $table = $obParent->table_name;
        }
        $htmlStr = "\n";
        if ($html) $htmlStr = "<br/>";
        $sql = "CREATE TABLE IF NOT EXISTS `".$table."` (".$htmlStr."
                   ".implode(", ".$htmlStr, $text_sql).($primary != '' ? " ,".$htmlStr."
                   $primary" : '').$htmlStr."
                   ) ENGINE = InnoDB COMMENT=".$this->dbConnection->quoteValue($this->name).";";
      }
    }
    return $sql;
  }

  protected function beforeDelete() {
//    Yii::app()->db->createCommand('DELETE FROM da_domain_object WHERE id_object = :id_object')->execute(array(':id_object'=>$this->id_object));

    // удаляем права по ид объекта
    $items = Yii::app()->authManager->getAuthItemByIdObject($this->id_object);
    foreach($items AS $item) {
      Yii::app()->authManager->removeAuthItem($item->name);
    }

    return parent::beforeDelete();
  }

  protected function afterSave() {
    parent::afterSave();
    if ($this->isNewRecord) {
      $idObject = $this->id_object;
      if ($this->object_type == self::OBJECT_TYPE_TABLE && $this->table_name != "") {  // Если создается объект у которого тип=Таблица, то создаем свойство Первичного ключа
        $p = ObjectParameter::newModel('ObjectParameter');
        $p->id_object = $idObject;
        $p->id_parameter_type = DataType::PRIMARY_KEY;
        $p->caption = 'id';
        $fieldName = 'id_'.str_replace(array('da_', 'pr_'), '', $this->table_name);
        $p->field_name = $fieldName;
        $p->id_parameter = $idObject.'-'.str_replace('_', '-', $fieldName);
        $p->setIsRequired(true);
        $p->save();
      }
    } else {
      if ($this->id_object != $this->getPkBeforeSave()) {
        ObjectParameter::model()->updateAll(array('id_object'=>$this->id_object), 'id_object=:obj', array(':obj' => $this->getPkBeforeSave()));
        ObjectParameter::model()->updateAll(array('add_parameter'=>$this->id_object), 'id_parameter_type=7 AND add_parameter=:obj', array(':obj' => $this->getPkBeforeSave()));
        DaObjectView::model()->updateAll(array('id_object'=>$this->id_object), 'id_object=:obj', array(':obj' => $this->getPkBeforeSave()));
        DaObjectViewColumn::model()->updateAll(array('id_object'=>$this->id_object), 'id_object=:obj', array(':obj' => $this->getPkBeforeSave()));
        File::model()->updateAll(array('id_object'=>$this->id_object), 'id_object=:obj', array(':obj' => $this->getPkBeforeSave()));
        Search::model()->updateAll(array('id_object'=>$this->id_object), 'id_object=:obj', array(':obj' => $this->getPkBeforeSave()));
      }
    }
  }
  protected function beforeSave() {
    if (!$this->isNewRecord) {
      $idObject = $this->id_object;
      //echo 'id='.$idObject;HU::dump($this);exit;
      $objectCurrent = DaObject::getById($idObject);
      if ($objectCurrent != null && $objectCurrent->object_type == self::OBJECT_TYPE_TABLE && $objectCurrent->table_name != null) {
        $tableNotExists = (Yii::app()->db->createCommand('SHOW TABLES LIKE :t')->queryScalar(array(':t'=>$objectCurrent->table_name)) == null);
        if ($tableNotExists) {
          if (Yii::app()->isBackend) Yii::app()->addMessage('Таблица '.$objectCurrent->table_name.' не существует, невозможно выполнить переименование в базе данных', BackendApplication::MESSAGE_TYPE_ERROR, true);
        } else { 
          $report = '';
          if ($objectCurrent->table_name != "" && $objectCurrent->table_name != $this->table_name) {
            $sql = 'RENAME TABLE `'.$objectCurrent->table_name.'` TO `'.$this->table_name.'`';
            Yii::app()->db->createCommand($sql)->execute();
            $report = $sql.'<br>';
          } 
          if ($objectCurrent->name != "" && $objectCurrent->name != $this->name) {
            $sql = 'ALTER TABLE `'.$this->table_name.'` COMMENT='.$this->dbConnection->quoteValue($this->name);
            Yii::app()->db->createCommand($sql)->execute();
            $report .= $sql;
          }
          if (Yii::app()->isBackend) Yii::app()->addMessage('Выполнено '.$report, BackendApplication::MESSAGE_TYPE_SUCCESS, true);
        }
      }
    }
    return parent::beforeSave();
  }




}