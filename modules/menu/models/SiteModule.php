<?php

/**
 * Модель для таблицы "da_site_module".
 *
 * The followings are the available columns in table 'da_site_module':
 * @property string $id_module
 * @property integer $id_php_script
 * @property string $name
 * @property integer $is_visible
 * @property string $content
 * @property string $html
 */
class SiteModule extends DaActiveRecord {

  const PLACE_LEFT        = 1;
  const PLACE_RIGHT       = 2;
  const PLACE_BOTTOM      = 3;
  const PLACE_TOP         = 4;
  const PLACE_CONTENT     = 5;
  const PLACE_FOOTER      = 6;
  const PLACE_CONTENT_TOP = 7;

  const ID_OBJECT = 103;

  protected $idObject = self::ID_OBJECT;

  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return SiteModule the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'da_site_module';
  }
  
  public function isVisible() {
    return ($this->is_visible === 1);
  }
  public function setIsVisible($bool) {
    $this->is_visible = ($bool ? 1 : 0);
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
      array('name', 'required'),
      array('id_php_script, is_visible', 'numerical', 'integerOnly'=>true),
      array('name', 'length', 'max'=>255),
      array('content, html', 'safe'),
      array('id_module', 'unsafe'),
    );
  }

  public function getIdPhpScriptInstance() {
    return $this->id_php_script;
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    return array(
      'place' => array(self::HAS_ONE, 'SiteModulePlace', 'id_module', 'joinType' => 'JOIN', 'order' => 'place.place, place.sequence'),
      'places' => array(self::HAS_MANY, 'SiteModulePlace', 'id_module'),
      'phpScriptInstance' => array(self::HAS_ONE, 'PhpScriptInstance', array('id_php_script' => 'id_php_script'), ),
      'files' => array(self::HAS_MANY, 'File', 'id_instance', 'condition' => 'id_object = :obj', 'params' => array(':obj' => self::ID_OBJECT)),
//      'phpScript' => array(self::HAS_ONE, 'PhpScript', array('id_php_script_type' => 'id_php_script_type'), 'select' => array('file_path', 'class_name'), 'through' => 'phpScriptInstance'),
    );
  }

  public function defaultScope() {
    $alias = $this->getTableAlias(true, false);
    return array(
        'condition' => $alias.'.is_visible=1',
    );
  }
  
  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
      'id_module' => 'Id Module',
      'id_php_script' => 'Php Script',
      'name' => 'Name',
      'is_visible' => 'Is Visible',
      'content' => 'Content',
      'html' => 'Html',
    );
  }

  public function behaviors() {
    return array(
      'CascadeDelete' => array(
        'class' => 'CascadeDeleteBehavior',
        'relations' => array(
          'places',
          'phpScriptInstance',
        ),
      ),
        
      /*'activerecord-relation'=>array(
          'class'=>'EActiveRecordRelationBehavior',
          'useTransaction' => false,
      ),*/
    );
  }

  public function getBackendEventHandler() {
    return array(
      'class' => 'menu.backend.SiteModuleEventHandler',
    );
  }

}