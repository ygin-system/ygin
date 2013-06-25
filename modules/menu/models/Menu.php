<?php

/**
 * This is the model class for table "da_menu".
 *
 * The followings are the available columns in table 'da_menu':
 * @property integer $id
 * @property string $name
 * @property string $caption
 * @property string $content
 * @property integer $visible
 * @property integer $id_parent
 * @property integer $sequence
 * @property integer $handler
 * @property string $note
 * @property string $alias
 * @property string $title_teg
 * @property string $meta_description
 * @property string $meta_keywords
 * @property integer $go_to_type
 * @property integer $id_module_template
 * @property string $external_link
 * @property integer $external_link_type
 * @property integer $removable
 * @property integer $image
 */
class Menu extends DaActiveRecord implements ISearchable {
  
  const ID_OBJECT = 'ygin-menu';
  
  private $_modules = null;
  protected $idObject = self::ID_OBJECT;

  const SEPARATOR = '.';
  
  const GO_TO_LIST_CHILD  = 1;
  const GO_TO_FIRST_CHILD = 2;
  const GO_TO_FILE        = 3;
  const GO_TO_SHOW_BLANK  = 4;
  
  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return Menu the static model class
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName()
  {
    return 'da_menu';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules()
  {
    return array(
      array('name, id_module_template', 'required'),
      array('visible, id_parent, sequence, handler, go_to_type, id_module_template, external_link_type', 'numerical', 'integerOnly'=>true),
      array('name, caption, title_teg, meta_description, meta_keywords, external_link', 'length', 'max'=>255),
      array('note', 'length', 'max'=>200),
      array('alias', 'length', 'max'=>100),
      array('content', 'safe'),
    );
  }
  
  public function behaviors() {
    return array(
      'tree' => array(
        'class' => 'ActiveRecordTreeBehavior',
        'order' => 'id_parent DESC, sequence ASC',
        'idParentField' => 'id_parent',
      ),
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    return array(
      '_firstFile' => array(self::HAS_MANY, 'File', array('id_instance'), 'joinType' => 'INNER JOIN', 'select' => 'id_file, file_path, id_object, id_instance, id_parameter, id_property', 'limit' => 1, 'on' => '_firstFile.id_object = :id_object', 'order' => '_firstFile.id_file_type, _firstFile.file_path', 'params' => array(':id_object' => $this->getIdObject())),
      'imageFile' => array(self::HAS_ONE, 'File', array('id_file' => 'image'), 'select' => 'id_file, file_path, id_object, id_instance, id_parameter, id_property'),
    );
  }

  public function getFirstFile() {
    $ff = $this->_firstFile;
    if (is_array($ff) && count($ff) == 1) {
      return $ff[0];
    }
    return null;
  }
  
  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels()
  {
    return array(
      'id' => 'ID',
      'name' => 'Название раздела',
      'caption' => 'Заголовок',
      'content' => 'Content',
      'visible' => 'Visible',
      'id_parent' => 'Родитель',
      'sequence' => 'Sequence',
      'handler' => 'Handler',
      'note' => 'Note',
      'alias' => 'Alias',
      'title_teg' => 'Title Teg',
      'meta_description' => 'Meta Description',
      'meta_keywords' => 'Meta Keywords',
      'go_to_type' => 'Go To Type',
      'id_module_template' => 'Id Module Template',
      'external_link' => 'External Link',
      'external_link_type' => 'External Link Type',
    );
  }

  public function getSearchTitle() {
    return $this->getCaption();
  }
  public function getSearchUrl() {
    return $this->getUrl();
  }
  public function setCaption($caption) {
    $this->caption = $caption;
  }
  
  public function getCaption() {
    return $this->caption;
  }
  
  public function getIsVisible() {
    return $this->visible == 1;
  }
  public function setVisible($bool) {
    $this->visible = ($bool ? 1 : 0);
  }

  public function setName($name) {
    $this->name = $name;
  }
  public function getName() {
    return $this->name;
  }

  /**
   * Возможность удаления раздела
   * @return bool
   */
  public function isRemovable() {
    return ($this->removable == 1);
  }
  public function setRemovable($value) {
    $this->removable = ($value ? 1 : 0);
  }
  
  public static function getAll() {
    return self::model()->getTree();
  }
  
  protected function isStaticMenu() {
    return empty($this->uri) && empty($this->external_link);
  }
  public function getGoToType() {
    return $this->go_to_type;
  }
  public function getExternalLink() {
    return $this->external_link;
  }
  
  
  public function getByAlias($alias) {
    if ($this->alias == $alias) {
      return $this;
    }
    
    $child = $this->getChild();
    $childCount = $this->getChildCount();
    for ($i = 0; $i < $childCount; $i++) {
      $findMenu = $child[$i]->getByAlias($alias);
      if ($findMenu !== null) {
        return $findMenu;
      }
    }
    
    return null;
  }
  
  public function getByUri($link) {
    if ($this->uri == $link) {
      return $this;
    }
    
    $child = $this->getChild();
    $childCount = $this->getChildCount();
    for ($i = 0; $i < $childCount; $i++) {
      $findMenu = $child[$i]->getByUri($link);
      if ($findMenu !== null) {
        return $findMenu;
      }
    }
    
    return null;
  }
  
  /**
   * возвращает урл для статического раздела ввиде
   * menu.submenu.submenu_submenu
   */
  private function getStaticUrl() {
    $parentMenu = $this->getParent();
    $url = '';
    if ($parentMenu !== null && $parentMenu->isStaticMenu()) {
      $url = $parentMenu->getStaticUrl();
    }
    
    if (!empty($url)) {
      $url .= self::SEPARATOR.$this->alias;
    } else {
      $url = $this->alias;
    }
    return $url;
  }
  
  public function getUrl() {
    //Ссылка на другю страницу
    if (!empty($this->external_link)) {
      return $this->external_link;
    }
    
    //Динамический раздел
    if (!empty($this->uri)) {
      return $this->uri;
    }
    
    if ($this->go_to_type == Menu::GO_TO_FILE) {
      // Если в типе раздела указано, что нужно возвращать файл, то формируем ссылку на файл:
      // Если у раздела есть контент, то возвращаем ссылку на раздел, не смотря на то, что указан файл.
      $file = $this->firstFile;
      if ($file != null) {
        $res = $file->getUrlPath();
        /*if (DA_USE_FULL_LINK) {
          $idDomain = $this->getIdDomainInstance();
          $domain = Domain::loadByIdDomain($idDomain);
          $res = "http://".$domain->getDomainName().$res;
        }*/
        return $res;
      }
    }
    
    //Статический раздел
    $url = $this->getStaticUrl();
    if ($url == '') $url = '/';
    if ($url == '/') return $url;
    $result = Yii::app()->createUrl(MenuModule::ROUTE_STATIC_MENU, array(MenuModule::ROUTE_STATIC_MENU_PARAM => $url));
    return $result;
  }
  
  public function getByRoute($controller, $action) {
    if (!empty($this->controller)) {
      if ($this->controller == $controller) {
        if ($this->action == '*') { //для любого действия контроллера
          return $this;
        }
        $actions = explode(',', $this->action);
        $actionsCount = count($actions);
        for ($i = 0; $i < $actionsCount; $i++) { //соответствует ли действию раздел
          if (trim($actions[$i]) == $action) {
            return $this;
          }
        }
      }
    }
    
    $childCount = $this->getChildCount();
    for ($i = 0; $i < $childCount; $i++) {
      $child = $this->getChild();
      $res = $child[$i]->getByRoute($controller, $action);
      if ($res !== null) {
        return $res;
      }
    }
    return null;
  }
  
  public function getVisibleChildCount() {
    $c = 0;
    $childCount = $this->getChildCount();
    
    for($i = 0; $i < $childCount; $i++) {
      $child = $this->getChild();
      if ($child[$i]->isVisible) {
        $c++;
      }
    }
    
    return $c;
  }

  
  // МОДУЛИ САЙТА
  /**
   * Получить все модули раздела
   * @return array SiteModule
   */
  public function getModules() {
    if ($this->_modules !== null) return $this->_modules;
    
    $this->_modules = array();
    $idTemplate = $this->id_module_template;

    if ($idTemplate == null) {
      // Если модулей нет, то устанавливаем родительские модули
      $parent = $this->getParent();
      if ($parent != null) {
        $this->_modules = $parent->getModules();
        return $this->_modules;
      } else {
        // получаем дефолтный шаблон модулей
        $idTemplate = SiteModuleTemplate::getIdDefaultTemplate();
        if ($idTemplate == null) return $this->_modules;
      }
    }
    
    $this->_modules = SiteModule::model()->with(array(
      'place' => array('condition' => 'place.id_module_template=:id_template', 'params' => array('id_template' => $idTemplate)),
      'phpScriptInstance.phpScript',
    ))->findAll();
    
    return $this->_modules;
  }
  /**
   * Получить модули по их месту в шаблоне модулей
   * @param int $place
   * @return array SiteModule
   */
  public function getModulesByPlace($place) {
    $result = array();
    $modules = $this->getModules();
    foreach ($modules AS $module) {
      if ($module->place->place == $place) $result[] = $module;
    }
    return $result;
  }
  
  /**
   * Получить кол-во модулей
   * @param int $place Дополнительный параметр, позволяющий уточнить место модулей
   */
  public function getCountModule($place=null) {
    if ($place == null) return count($this->getModules());
    return count($this->getModulesByPlace($place));
  }

  /**
   * Удаляет вложенные разделы и возвращает истину, если всё удалилось успешно
   */
  public function deleteChildMenu() {
    $child = $this->getChild();
    // Удаляем дочерние разделы, если они есть
    foreach($child AS $childMenu) {
      if ($childMenu->deleteChildMenu()) {
        $childMenu->delete();
      } else {
        return false;
      }
    }
    return true;
  }
  protected function beforeSave() {
    $this->alias = HText::translit($this->alias, '_', false);
    return parent::beforeSave();
  }

  protected function beforeDelete() {
    if (!$this->isRemovable()) {
      throw new ErrorException('Раздел нельзя удалить, так как он не отмечен как удаляемый');
    }
    $all = self::getAll();
    $sm = $all->getById($this->id);
    if ($sm->deleteChildMenu()) {
      return parent::beforeDelete();
    }
    return false;
  }
  public function isProcessDeleteChild() {
    // Разрешаем удаление потомков вместе с текущим разделом
    return true;
  }

  public function getBackendEventHandler() {
    return array(
      'class' => 'menu.backend.MenuEventHandler',
    );
  }
  
}