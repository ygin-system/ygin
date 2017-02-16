<?php

/**
 * Модель для таблицы "da_php_script".
 *
 * The followings are the available columns in table 'da_php_script':
 * @property integer $id_php_script
 * @property integer $id_php_script_type
 * @property integer $id_module
 * @property string $params_value
 *
 * @property PhpScript $phpScript
 */
class PhpScriptInstance extends BaseActiveRecord {

  private $_parametersValue = null;

  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return PhpScriptInstance the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  private function initParametersValue() {
    if ($this->_parametersValue === null) {
      if ($this->params_value === null) {
        $this->_parametersValue = array();
      } else {
        $this->_parametersValue = unserialize($this->params_value);
      }
    }
  }
  public function getParametersValue() {
    $this->initParametersValue();
    return $this->_parametersValue;
  }
  public function getParameterValue($name, $withoutProcess=false) {
    $this->initParametersValue();
    if ($withoutProcess) {
      return (isset($this->_parametersValue[$name]) ? $this->_parametersValue[$name] : null);
    }
    $config = $this->phpScript->getParameterConfig($name);
    if ($config == null) {
      throw new ErrorException('Запрошен недопустимый параметр '.$name.' пхп-скрипта');
    }
    $value = null;
    if (isset($this->_parametersValue[$name])) {
      $value = $this->_parametersValue[$name];
    } else if ($config['required']) {
      $value = $config['default'];
    }
    if ($config['type'] == DataType::EVAL_EXPRESSION) {
      if ($value == null) $value = 'null';
      eval('$value = '.$value.';');
    } else if ($config['type'] == DataType::BOOLEAN) {
      $value = ($value == '1');
    }
    return $value;
  }

  public function setParameterValue($name, $value) {
    $this->initParametersValue();
    $this->_parametersValue[$name] = $value;
    $this->params_value = serialize($this->_parametersValue);
  }
  public function setParametersValue(array $parametersValue) {
    $this->_parametersValue = $parametersValue;
    $this->params_value = serialize($this->_parametersValue);
  }

  public function getIdModule() {
    return $this->id_module;
  }
  public function getIdPhpScriptType() {
    return $this->id_php_script_type;
  }
  public function getIdPhpScript() {
    return $this->id_php_script;
  }
  public function setIdPhpScriptType($id) {
    $this->id_php_script_type = $id;
  }
  public function setIdModule($id) {
    $this->id_module = $id;
  }
  
  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'da_php_script';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
      array('id_php_script_type', 'required'),
      array('id_module', 'numerical', 'integerOnly'=>true),
      array('id_php_script', 'unsafe'),
      array('id_php_script_type', 'length', 'max'=>255),
    );
  }
  
  /**
   * @return array relational rules.
   */
  public function relations() {
    return array(
      'phpScript' => array(self::BELONGS_TO, 'PhpScript', array('id_php_script_type' => 'id_php_script_type'), ),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
      'id_php_script' => 'Id Php Script',
      'id_php_script_type' => 'Id Php Script Type',
      'id_module' => 'Id Module',
    );
  }

}