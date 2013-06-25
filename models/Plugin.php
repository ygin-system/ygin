<?php

/**
 * Модель для таблицы "da_plugin".
 *
 * The followings are the available columns in table 'da_plugin':
 * @property integer $id_plugin
 * @property string $name
 * @property string $code
 * @property integer $status
 * @property string $data
 * @property string $config
 * @property string $class_name
 */
class Plugin extends DaActiveRecord {
  
  const STATUS_NEW = 1;  // новый, ещё не установленный
  const STATUS_ENABLE = 2;  // установленный, работающий
  const STATUS_DISABLE = 3;  // установленный, отключенный
  const STATUS_DELETE = 4;  // удаленный

  const ID_OBJECT = 527;
  protected $idObject = self::ID_OBJECT;
  
  private $_object = null;
  
  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return Plugin the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'da_plugin';
  }
  
  public function __call($name, $parameters) {
    $object = $this->getPluginObject();
    if ($object !== null) {
      if (method_exists($object, $name)) {   // методы делегата
        return call_user_func_array(array($object, $name), $parameters);
      }
    }
    return parent::__call($name,$parameters);
  }
  /*public function __get($name) {
    if ($name != 'class_name' && ($object=$this->getPluginObject()) !== null) {
      if (isset($object->$name)) return $object->$name;
      //$getter = 'get'.$name;
      //if (method_exists($object, $getter)) return $object->$getter();
    }
    return parent::__get($name);
  }*/


  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
      array('name, code, class_name', 'required'),
      array('status', 'numerical', 'integerOnly'=>true),
      array('name, code', 'length', 'max'=>255),

    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    return array(
    );
  }
  
  public function getData() {
    if ($this->data === null) return null;
    return unserialize($this->data);
  }
  public function getConfig() {
    if ($this->config === null) return null;
    return unserialize($this->config);
  }
  public function setData($data) {
    $this->data = serialize($data);
  }
  public function setConfig($config) {
    $this->config = serialize($config);
  }
  public function getParamsValue() {
    return $this->getParametersValueFromConfig($this->getConfig(), $this->getData());
  }
  
  public function notDeleted() {
    $this->getDbCriteria()->mergeWith(array(
        'condition' => $this->getTableAlias().'.status!='.self::STATUS_DELETE,
    ));
    return $this;
  }
  public function enabled() {
    $this->getDbCriteria()->mergeWith(array(
        'condition' => $this->getTableAlias().'.status='.self::STATUS_ENABLE,
    ));
    return $this;
  }

  public static function loadByCode($code) {
    return Plugin::model()->notDeleted()->find('code=:code', array(':code' => $code));
  }

  private function getPluginObject(array $configPlugin = array()) {
    if ($this->_object === null) {
      $className = Yii::import($this->class_name, true);
      $rc = new ReflectionClass($className);
      if ($rc->implementsInterface("IApplicationPlugin")) {
        $reflectionMethod = new ReflectionMethod($className, 'createPlugin');
        unset($configPlugin['class']); //, $params['category'], $params['enabled']);
        $this->_object = $reflectionMethod->invoke(null, $configPlugin);
      } else {
        throw new ErrorException('Плагин '.$className.' должен расширять интерфейс IApplicationPlugin');
      }
    }
    return $this->_object;
  }
  
  public function getUrl() {
    if (!$this->isNewRecord) {
      return Yii::app()->createUrl(PluginModule::ROUTE_PLUGIN_VIEW, array('code' => $this->code));
    }
    return '/';
  }
  
  public function getIsEnabled() {
    return (int)$this->status === self::STATUS_ENABLE;
  }
  
}