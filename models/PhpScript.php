<?php
/**
 * Модель для таблицы "da_php_script_type".
 *
 * The followings are the available columns in table 'da_php_script_type':
 * @property integer $id_php_script_type
 * @property string $file_path
 * @property string $description
 * @property integer $id_php_script_interface
 * @property integer $active
 */
class PhpScript extends DaActiveRecord {

  const ID_PHP_SCRIPT_INTERFACE_CONTENT = 1;
  const ID_PHP_SCRIPT_INTERFACE_MODULE = 2;
  
  const ID_OBJECT = 80;

  protected $idObject = self::ID_OBJECT;

  private $_parametersConfig = null;
  
  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return PhpScript the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  public function getParametersConfig() {
    if ($this->_parametersConfig === null) {
      $className = $this->import();
      $rc = new ReflectionClass($className);
      if ($rc->isSubclassOf("IParametersConfig")) {
        $reflectionMethod = new ReflectionMethod($className, 'getParametersConfig');
        $this->_parametersConfig = $reflectionMethod->invoke(null);
      } else {
        $this->_parametersConfig = array();
      }
    }
    return $this->_parametersConfig;
  }
  public function getCountParameters() {
    return count($this->getParametersConfig());
  }
  public function getParameterConfig($paramName) {
    $config = $this->getParametersConfig();
    return (isset($config[$paramName]) ? $config[$paramName] : null);
  }

  public function import() {
    return Yii::import($this->file_path, true);
  }

  public function getIdPhpScriptType() {
    return $this->id_php_script_type;
  }
  public function getDescription() {
    return $this->description;
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'da_php_script_type';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
      array('id_php_script_type', 'match', 'pattern'=>'~\d+|[a-zA-Z\d\_]+\-[a-zA-Z\d\_\-]*[a-zA-Z\d\_]+~', 'message'=>'ИД должен содержать дефис'),
      array('id_php_script_type', 'unique'),
      array('file_path, id_php_script_type, id_php_script_interface', 'required'),
      array('id_php_script_interface', 'numerical', 'integerOnly'=>true),
      array('id_php_script_type, file_path, description', 'length', 'max'=>255),
    );
  }

  protected function afterSave() {
    if (!$this->isNewRecord) {
      $idOldPhpScript = $this->getPkBeforeSave();
      if ($this->id_php_script_type != $idOldPhpScript) {
        PhpScriptInstance::model()->updateAll(array('id_php_script_type'=>$this->id_php_script_type), 'id_php_script_type=:id', array(':id' => $idOldPhpScript));
        DaObjectViewColumn::model()->updateAll(array('handler'=>$this->id_php_script_type), 'handler=:id', array(':id' => $idOldPhpScript));
      }
    }
    return parent::afterSave();
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    return array(
    );
  }

  public function defaultScope() {
    $alias =  $this->getTableAlias(true, false);
    return array(
      'condition' => "$alias.active = 1",
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
      'id_php_script_type' => 'Id Php Script Type',
      'file_path' => 'File Path',
      'description' => 'Description',
      'id_php_script_interface' => 'Id Php Script Interface',
    );
  }

}