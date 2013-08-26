<?php

/**
 * Модель для таблицы "da_object_parameters".
 *
 * The followings are the available columns in table 'da_object_parameters':
 * @property integer $id_object
 * @property integer $id_parameter
 * @property integer $id_parameter_type
 * @property integer $sequence
 * @property string $widget
 * @property string $caption
 * @property string $field_name
 * @property integer $add_parameter
 * @property string $default_value
 * @property integer $not_null
 * @property string $sql_parameter
 * @property integer $is_unique
 * @property integer $group_type
 * @property integer $need_locale
 * @property integer $search
 * @property integer $is_additional
 * @property string $hint
 * @property integer $visible
 */
class ObjectParameter extends DaActiveRecord {

  const ID_OBJECT = 21;
  protected $idObject = self::ID_OBJECT;

  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return ObjectParameter the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  public function getType() {
    return $this->id_parameter_type;
  }
  public function getIdParameter() {
    return $this->id_parameter;
  }
  public function getIdObjectParameter() {
    return $this->id_object;
  }
  public function getFieldName() {
    return $this->field_name;
  }
  public function getAdditionalParameter() {
    return $this->add_parameter;
  }
  public function getSqlParameter() {
    return $this->sql_parameter;
  }
  public function isRelation() {
    return $this->group_type;
  }
  public function getDefaultValue() {
    return $this->default_value;
  }
  public function getDataType() {
    return $this->getType();
  }
  public function isUnique() {
    return ($this->is_unique == 1);
  }
  public function isRequired() {
    return ($this->not_null == 1);
  }
  public function isSearch() {
    return ($this->search == 1);
  }
  public function isVisible() {
    return ($this->visible == 1);
  }
  public function getTypeGroup() {
    return ($this->group_type == 1);
  }
  public function setIsRequired($isRequired) {
    $value = ($isRequired ? 1 : 0);
    $this->not_null = $value;
  }
  public function getCaption() {
    return $this->caption;
  }
  public function getHint() {
    return $this->hint;
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'da_object_parameters';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
      array('id_parameter', 'match', 'pattern'=>'~\d+|[a-zA-Z\d\_]+\-[a-zA-Z\d\_\-]*[a-zA-Z\d\_]+~', 'message'=>'ИД должен содержать дефис'),
      array('id_parameter, caption', 'required'),
      array('id_parameter_type, sequence, not_null, is_unique, group_type, need_locale, search, is_additional, visible', 'numerical', 'integerOnly'=>true),
      array('id_parameter, id_object, widget, caption, field_name, default_value, add_parameter, sql_parameter', 'length', 'max'=>255),
      array('hint', 'safe'),
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
      'id_object' => 'Id Object',
      'id_parameter' => 'Id Parameter',
      'id_parameter_type' => 'Id Parameter Type',
      'sequence' => 'Sequence',
      'widget' => 'Widget',
      'caption' => 'Caption',
      'field_name' => 'Field Name',
      'add_parameter' => 'Add Parameter',
      'default_value' => 'Default Value',
      'not_null' => 'Not Null',
      'sql_parameter' => 'Sql Parameter',
      'is_unique' => 'Is Unique',
      'group_type' => 'Group Type',
      'need_locale' => 'Need Locale',
      'search' => 'Search',
      'is_additional' => 'Is Additional',
      'hint' => 'Hint',
    );
  }

  /**
   * @return DaObject возвращает объект свойтва
   */
  public function getObject() {
    return DaObject::getById($this->id_object);
  }

  protected function beforeSave() {
    if (!$this->isNewRecord) {
      $idObject = $this->id_object;
      $notChangeObject = array(20, 21);
      if (!in_array($idObject, $notChangeObject)) {
        $this->sqlChange($this);
      }
    } else {
      // если создается свойство типа Первичный ключ или Родительский ключ, и поле такого типа уже есть, то кидаем исключение.
      $type = $this->getType();
      if (in_array($type, array(DataType::PRIMARY_KEY, DataType::ID_PARENT))) {
        $object = $this->getObject();
        if ($object->getFieldByType($type) !== null) throw new CException('Свойство такого типа уже существует.');
      }
    }
    return parent::beforeSave();
  }
  protected function afterSave() {
    if ($this->isNewRecord) {
      $idObject = $this->id_object;
      $notChangeObject = array(20, 21);
      if (!in_array($idObject, $notChangeObject)) {
        $this->sqlChange($this, 'insert');
      }
    } else {
      $pk = $this->getPkBeforeSave();
      $idOldParameter = $pk['id_parameter'];
      if ($this->id_parameter != $idOldParameter) {
        DaObject::model()->updateAll(array('id_field_order'=>$this->id_parameter), 'id_field_order=:param', array(':param' => $idOldParameter));
        DaObject::model()->updateAll(array('id_field_caption'=>$this->id_parameter), 'id_field_caption=:param', array(':param' => $idOldParameter));
        File::model()->updateAll(array('id_parameter'=>$this->id_parameter), 'id_parameter=:param', array(':param' => $idOldParameter));
        DaObjectViewColumn::model()->updateAll(array('id_object_parameter'=>$this->id_parameter), 'id_object_parameter=:param', array(':param' => $idOldParameter));
      }
    }
    return parent::afterSave();
  }
  protected function afterDelete() {
    $this->sqlChange($this, 'delete');
    return parent::afterDelete();
  }
  public function onlyVisible() {
    $this->getDbCriteria()->mergeWith(array(
      'condition' => $this->getTableAlias().'.visible=1',
    ));
    return $this;
  }
  private function sqlChange(ObjectParameter $instance, $mode=null) {
    $idObject = $instance->id_object;
    if ($idObject == null) return false;
    $isDelete = $mode == 'delete';
    $isInsert = $mode == 'insert';
    $objectCurrent = DaObject::getById($idObject);
    $table = $objectCurrent->table_name;
    $type = $instance->getDataType();
    $fieldName = $instance->getFieldName();

    if ($objectCurrent->object_type != DaObject::OBJECT_TYPE_TABLE) {
      return false;
    }
    if ($table == null) {
      if (Yii::app()->isBackend) Yii::app()->addMessage('Свойство не было '.($isDelete?'удалено':($isInsert?'создано':'изменено')).' в базе данных, т.к. у объекта не указано имя таблицы', BackendApplication::MESSAGE_TYPE_ERROR, true);
      return false;
    }
    $tableNotExists = (Yii::app()->db->createCommand('SHOW TABLES LIKE :t')->queryScalar(array(':t'=>$objectCurrent->table_name)) == null);

    $sqls = array();
    $allowQuery = true;
    $abstractCurrent = (DataType::getSqlType($type) == null);
    $instanceOld = null;
    if ($isDelete) {
      $instanceOld = $instance;
    } else if (!$isInsert) {
      $instanceOld = ObjectParameter::model()->findByIdInstance($instance->getIdInstance());
      if ($instanceOld == null) { // такой вариант может быть только в случае, если у параметра поменяли ИД. Тогда мы не можем найти старый параметр и не можем понять какие были данные. Поэтому ничего не делаем.
        return;
      }
    }
    // Если поле меняется, загружаем старые данные и проверяем, поменялось ли что-то
    if (!$isInsert && !$isDelete) {
      $isTypeChange = (DataType::getSqlType($instanceOld->getDataType()) != DataType::getSqlType($type));
      $allowQuery = $instanceOld->getFieldName() != $fieldName ||
          $isTypeChange ||
          $instanceOld->getDefaultValue() != $instance->getDefaultValue() ||
          $instanceOld->isRequired() != $instance->isRequired();
      if ($isTypeChange) {
        // если тип поля меняется с SQL на абстрактный - удаляем поле
        if ($abstractCurrent && DataType::getSqlType($instanceOld->getDataType()) != null) {
          $sqls[]= 'ALTER TABLE `'.$table.'` DROP `'.$instanceOld->getFieldName().'`';
          // наоборот, если тип поля меняется с абстрактного на SQL - добавляем поле
        } else if (!$abstractCurrent && DataType::getSqlType($instanceOld->getDataType()) == null) {
          $isInsert = true;
        }
      }
    }
    $msg = '';
    // Составляем запросы
    if ($allowQuery && !$abstractCurrent) {
      $fieldExists = false;
      $countFields = 0;
      if (!$tableNotExists) {
        $columns = Yii::app()->db->createCommand('SHOW COLUMNS FROM '.$table)->queryAll();
        if ($instanceOld != null) $fieldName = $instanceOld->getFieldName();
        foreach($columns AS $column) {
          if ($column['Field'] == $fieldName) {
            $fieldExists = true;
          }
          $countFields ++;
        }
      }
      if ((!$isInsert || $isDelete) && !$fieldExists) {
        $allowQuery = false;
        $msg = 'В таблице '.$table.' не существует поля "'.$instanceOld->getFieldName().'"';
      }
      if ($isInsert && $fieldExists) {
        $allowQuery = false;
        $msg = 'В таблице '.$table.' уже существует поле "'.$instance->getFieldName().'"';
      }
      // TODO проверки еще [Field] => person_type [Type] => int(8) [Null] => YES [Key] => [Default] => [Extra] =>
      if ($allowQuery) {
        if ($isDelete) {
          if ($countFields == 1) {
            $sqls[] = 'DROP TABLE `'.$table.'`';
          } else {
            $sqls[] = 'ALTER TABLE `'.$table.'` DROP `'.$instance->getFieldName().'`';
          }
        } else {
          $definition = '`'.$instance->getFieldName().'` '.DataType::getSqlType($type);
          if ($instance->isRequired()) {
            $definition .=  ' NOT NULL';
          }
          if ($instance->getDefaultValue() != null && !in_array($type, array(DataType::TEXTAREA, DataType::EDITOR))) {
            $definition .=  ' default \''.$instance->getDefaultValue().'\'';
          }
          if ($type == DataType::PRIMARY_KEY) {
            $definition .=  ' AUTO_INCREMENT';
          }
          $definition .= ' COMMENT  '.$this->dbConnection->quoteValue($instance->getCaption());

          // Создаем таблицу с полем
          if ($tableNotExists) {
            $sqls[] = $objectCurrent->getCreateTableSql();
            // Таблица уже существует
          } else {
            $sql = 'ALTER TABLE `'.$table.'`';
            if ($isInsert) {
              $sql .= ' ADD '.$definition.' ';
            } else {
              $sql .= ' CHANGE `'.$instanceOld->getFieldName().'` '.$definition.' ';
            }
            $sqls[] = $sql;
            if ($isInsert) {
              if ($type == DataType::PRIMARY_KEY) {
                $sqls[] = 'ALTER TABLE `'.$table.'` ADD PRIMARY KEY (`'.$fieldName.'`)';
              }
              if ($instance->isUnique()) {
                $sqls[] =  'ALTER TABLE `'.$table.'` ADD UNIQUE (`'.$fieldName.'`)';
              }
            }
          }
        }
      }
    }

    foreach ($sqls as $sql) {
      Yii::app()->db->createCommand($sql)->execute();
      $msg .= 'Выполнено: '.$sql.'<br>';
    }
    if ($msg != '') {
      if (Yii::app()->isBackend) Yii::app()->addMessage($msg);
    }
  }
  
  public function getBackendEventHandler() {
    return array(
      'class' => 'backend.backend.objectParameter.ObjectParameterEventHandler',
    );
  }

}