<?php
/* SVN FILE: $Id: RbamModule.php 28 2011-04-05 19:04:17Z Chris $*/
/**
* Role Based Access Manager Module class file.
* Provides management of RBAC authorisation data.
*
* @copyright  Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package    RBAM
* @since      V1.0.0
* @version    $Revision: 28 $
* @license    BSD License (see documentation)
*/
/**
* Role Based Access Manager Module class
* @package    RBAM
*/
class RbamModule extends CWebModule {
  /**
  * @property string Name of the role that grants permission to manage authorisation items and user role assignments.
  */
  public $rbacManagerRole = 'RBAC Manager';
  /**
  * @property stringName of the role that grants permission to manage authorisation items.
  */
  public $authItemsManagerRole = 'Auth Items Manager';
  /**
  * @property string Name of the role that grants permission to manage user role assignments.
  */
  public $authAssignmentsManagerRole = 'Auth Assignments Manager';
  /**
  * @property string Name of the role that grants permissions to users that are logged in.
  * This will be added as to CAuthManager::defaultRoles.
  */
  public $authenticatedRole = 'Authenticated';
  /**
  * @property string Name of the role that grants permissions to users that are not logged in.
  * This will be added to CAuthManager::defaultRoles.
  */
  public $guestRole = 'Guest';
  /**
  * @property integer The number of auth items shown in gridViews.
  */
  public $pageSize = 10;
  /**
  * @property integer The number of items displayed in the relationship gridViews
  * of the Manage Item screen.
  * If empty defaults to pageSize.
  * @see $pageSize
  */
  public $relationshipsPageSize = 5;
  /**
  * @property string class The class name of the user model.
  */
  public $userClass = 'User';
  /**
  * @property string The name of the attribute that provides a unique id in the user model.
  */
  public $userIdAttribute = 'id';
  /**
  * @property mixed Attribute(s) in the user or related models used to display
  * the user's name; compound attributes are supported, e.g. the user's given
  * and family names, e.g. "Angela Other".
  * string: if a single attribute, the name of the attribute.
  * If multiple attributes, a comma delimited list of the join string followed
  * by attribute names. If a comma is used in the join string escape it with a
  * backslash, e.g. '\, ,given_name,family_name'
  * array: the first element is the join string, subsequent elements are
  * attribute names, e.g. array(', ','profile.given_name','profile.family_name')
  *
  * If using compound elements you can specify which, if any, are to be rendered
  * as initials only by adding a comma delimited string or array as the final
  * element. This has a similar format as above; the first element is rendered
  * after an initial and the following elements are the attributes to be rendered
  * as initials, e.g. array(', ','profile.family_name','profile.given_name', array('.','profile.given_name'))
  * will render as "Other, A."
  * NOTE: if using a comma delimited string within a comma delimited string, the
  * delimiting commas in the internal string must be escaped. If you wish to use
  * a comma as the character after initials it must be escaped with a backslash,
  * not forgetting to escape the backslash if using a string in a string,
  * i.e. '\\\,'. The following are valid and equivalent:
  * + array(', ','family_name','given_name', array('.','given_name'))
  * + array(', ','family_name','given_name', '.,given_name')
  * + '\, ,given_name,family_name,.\,given_name'
  */
  public $userNameAttribute = 'username';
  /**
  * @property array The criteria applied in order to filter the list of users.
  * CDbCriteria property values indexed by property name.
  */
  public $userCriteria = array();
  /**
  * @property string Path alias to RBAM's layout file.
  * This layout file is nested in the application layout file.
  * @see $applicationLayout
  */
  public $layout = 'rbam.views.layouts.main';
  /**
  * @property string Path alias to the application's layout file.
  * RBAM's content and layout are the content for this layout file. This will
  * need configuring for "ended" applications, e.g. has front-end and back-end
  * applications.
  * @see $layout
  */
  public $applicationLayout = 'application.views.layouts.main';
  /**
  * @property string The base URL used to access RBAM.
  * If NULL (default) the baseUrl is: '/parentModule1Id/…/parentModuleNId/rbam'.
  * Do not append any slash character to the URL.
  */
  public $baseUrl;
  /**
  * @property string The base script URL for all module resources (e.g. javascript,
  * CSS file, images).
  * If NULL (default) the integrated module resources (which are published as
  * assets) are used.
  */
  public $baseScriptUrl;
  /**
  * @property string The URL of the CSS file used by this module.
  * If NULL (default) the integrated CSS file is used.
  * If === FALSE a CSS file must be explicitly included, e.g. in the layout.
  */
  public $cssFile;
  /**
  * @property integer The number of milliseconds to show confirmation dialogs.
  * Dialogs can be closed before this time by clicking the "OK" button.
  */
  public $showConfirmation = 3000;
  /**
  * @property string The effect used to show JUI dialogs.
  * The following effects are available: blind, bounce, clip, drop, explode,
  * fold, highlight, puff, pulsate, scale, shake, size, slide.
  * Set to empty string for no effect.
  */
  public $juiShow = 'fade';
  /**
  * @property string The effect used to hide JUI dialogs.
  * The following effects are available: blind, bounce, clip, drop, explode,
  * fold, highlight, puff, pulsate, scale, shake, size, slide.
  * Set to empty string for no effect.
  */
  public $juiHide = 'puff';
  /**
  * @property string The root URL that contains all JUI JavaScript files.
  * If NULL (default) the JUI package included with Yii is published and used
  * to infer the root script URL. You should set this property if you intend to
  * use a JUI package whose version is different from the one included in Yii.
  * There must be a file whose name is specified by {@link juiScriptFile} under
  * this URL.
  * Do not append any slash character to the URL.
  */
  public $juiScriptUrl;
  /**
  * @property string The root URL that contains all JUI theme folders.
  * If NULL (default) the JUI package included with Yii is published and used to
  * infer the root theme URL. You should set this property if you intend to use
  * a theme that is not found in the JUI package included in Yii.
  * There must be a directory (case-sensitive) whose name is specified by
  * {@link juiTheme} under this URL.
  * Do not append any slash character to the URL.
  */
  public $juiThemeUrl;
  /**
  * @property string The JUI theme name.
  * There must be a directory whose name is the same as this property value
  * (case-sensitive) under the URL specified by {@link juiThemeUrl}.
  */
  public $juiTheme = 'base';
  /**
  * @property string The main JUI JavaScript file.
  * The file must exist under the URL specified by {@link juiScriptUrl}.
  * To include multiple script files (e.g. during development, to include
  * individual plugin script files rather than the minimized JUI script file),
  * set this property as an array of the script file names.
  * If === FALSE a JUI script file must be explicitly included, e.g. in the layout.
  */
  public $juiScriptFile = 'jquery-ui.min.js';
  /**
  * @property mixed The JUI theme CSS file name.
  * The file must exist under the URL specified by
  * {@link juiThemeUrl}/{@link juiTheme}.
  * To include multiple theme CSS files (e.g. during development, to include
  * individual plugin CSS files), set this property as an array of the CSS file
  * names.
  * If === FALSE a JUI CSS file must be explicitly included, e.g. in the layout.
  */
  public $juiCssFile = 'jquery-ui.css';
  /**
  * @property mixed Defines whether RBAM should initialise the RBAC system and if so
  * with what values.
  * WARNING: Initialising the RBAC system will clear existing authorisation
  * data (auth items, auth item children, and assignments).
  * String: the path to a file returns an array that defines the authorisation
  * data that RBAM will use to initialise the RBAC system. The array format is
  * that used by CPhpAuthManager, meaning that this option can be used to
  * import authorisation data if changing to CDbAuthManager; see below for the
  * array format.
  * Array: defines the authorisation data that RBAM will use to initialise the
  * RBAC system. The array format is that used by CPhpAuthManager; see below for
  * the array format.
  * Boolean: If === TRUE RBAM will initialise the RAC system with default auth
  * items and auth item children; the current user will be assigned the
  * "RBAC Manager" role.
  * If empty() (default) no initialisation is performed.
  */
  public $initialise;
  /**
  * @property mixed modules to exclude when generating authorisation data.
  * Either an array or comma delimited string of module ids.
  */
  public $exclude = 'rbam';
  /**
  * @property boolean Whether to show the RBAM menu. If true the RBAM module
  * renders the RBAM menu. Set false if the menu is rendered by the application.
  * @see getMenuItem()
  */
  public $showMenu = true;
  /**
  * @property boolean Set TRUE to enable development mode.
  * In development mode assets (e.g. JavaScript and CSS files) are published on
  * each access and options to initialise (if RbamModule::initialise is not
  * empty) and generate authorisation data are shown.
  */
  public $development = false;

  public $defaultController = 'Rbam';
  private $_cs;
  private $_defaultRoles;

  /**
  * Initialises the module
  */
  public function init() {
    $this->setImport(array(
      'rbam.components.*',
      'rbam.components.behaviors.*',
      'rbam.controllers.*',
      'rbam.models.*',
    ));

  }

  /**
  * Attach the RBAMxAuthManagerBehavior and pass the auth manager to the controller.
  * @param CController controller being run
  * @param CAction action being run
  * @return boolean whether the action should be executed
  */
  public function beforeControllerAction($controller, $action) {

    $this->_defaultRoles = array(
        'RBAC Manager' => $this->rbacManagerRole,
        'Auth Items Manager' => $this->authItemsManagerRole,
        'Auth Assignments Manager' => $this->authAssignmentsManagerRole,
        'Authenticated' => $this->authenticatedRole,
        'Guest' => $this->guestRole
    );

    $this->_setBaseUrl();
    $this->_publishCoreAssets();
    $this->_publishModuleAssets();

    $this->setComponents(array(
        'analyser' => array(
            'class' => 'rbam.components.RbamAnalyser',
            'exclude' => $this->exclude
        )
    ));

    if (!empty($this->initialise)) {
      $this->setComponents(array(
          'initialiser' => array(
              'class' => 'rbam.components.RbamInitialiser',
              'initialise' => $this->initialise,
              'defaultRoles' => $this->_defaultRoles,
          )
      ));
      $this->defaultController = 'RbamInitialise';
    }

    CHtml::$afterRequiredLabel = '';


    $controller->layout = $this->applicationLayout; // mixa, 20121012
    $imgPath = Yii::getPathOfAlias('ygin.modules.user.modules.rbam.assets.css').DIRECTORY_SEPARATOR;
    Yii::app()->clientScript->addDependResource('styles.css', array(
      $imgPath.'required.png' => '',
      $imgPath.'working.gif' => '',
    ));
    $authManager = Yii::app()->getAuthManager();
    $authManager->defaultRoles = array_merge($authManager->defaultRoles, array(
      $this->authenticatedRole, $this->guestRole
    ));
    if ($authManager instanceof CAuthManager)
      $authManager->attachBehavior('authManager', array(
        'class'=>($authManager instanceof CDbAuthManager?
          'RbamDbAuthManagerBehavior':'RbamPhpAuthManagerBehavior'
        ),
        'module'=>$this
      ));
    else
      throw new CException(Yii::t('RbamModule.rbam','AuthManager component is not an instance of CAuthManager'));
    $controller->authManager = $authManager;
    return true;
  }

  /**
  * Returns the default roles
  * @return array default roles
  */
  public function getDefaultRoles() {
    return $this->_defaultRoles;
  }

  /**
  * Determine the base url from parent module(s)
  */
  private function _setBaseUrl() {
    if (empty($this->baseUrl)) {
      $this->baseUrl='';
      $m = $this;
      do {
        $this->baseUrl = '/'.$m->getId().$this->baseUrl;
        $m = $m->getParentModule();
      } while (!is_null($m));
    }
    if (substr($this->baseUrl, -1)==='/') $this->baseUrl = substr($this->baseUrl, 0, -1);
  }

  /**
  * Publish jquery and JUI JavaScript files and the theme CSS file.
  */
  private function _publishCoreAssets() {
    if (is_null($this->_cs))
      $this->_cs = Yii::app()->getClientScript();

    /**
    * Determine the JUI package installation path.
    * This method will identify the JavaScript root URL and theme root URL.
    * If they are not explicitly specified, it will publish the included JUI package
    * and use that to resolve the needed paths.
    */
      if($this->juiScriptFile===null || $this->juiThemeUrl===null) {
      if($this->juiScriptUrl===null)
        $this->juiScriptUrl=$this->_cs->getCoreScriptUrl().'/jui/js';
      if($this->juiThemeUrl===null)
        $this->juiThemeUrl=$this->_cs->getCoreScriptUrl().'/jui/css';
    }

    /**
    * Register jquery and JUI JavaScript files and the theme CSS file.
    */
    if(is_string($this->juiCssFile))
      $this->_cs->registerCssFile($this->juiThemeUrl.'/'.$this->juiTheme.'/'.$this->juiCssFile);
    else if(is_array($this->juiCssFile)) {
      foreach($this->juiCssFile as $cssFile)
        $this->_cs->registerCssFile($this->juiThemeUrl.'/'.$this->juiTheme.'/'.$cssFile);
    }

    $this->_cs->registerCoreScript('jquery');
    $this->_cs->registerCoreScript('bbq');
    if(is_string($this->juiScriptFile))
      $this->_registerScriptFile($this->juiScriptFile);
    else if(is_array($this->juiScriptFile)) {
      foreach($this->juiScriptFile as $scriptFile)
        $this->_cs->registerScriptFile($scriptFile);
    }
  }

  /**
  * Publish module JavaScript and CSS files.
  */
  private function _publishModuleAssets() {
    if (is_null($this->_cs))
      $this->_cs = Yii::app()->getClientScript();

    if (!is_string($this->baseScriptUrl)) {
      // Republish if in development mode
      $this->baseScriptUrl = ($this->development ?
        Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('rbam.assets'), false, -1, true) :
        Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('rbam.assets'))
      );
    }

    $this->_cs->registerScriptFile($this->baseScriptUrl.'/js/jquery.rbam.js');

    if($this->cssFile!==false) {
      if($this->cssFile===null)
        $this->cssFile= $this->baseScriptUrl.'/css/styles.css';
      $this->_cs->registerCssFile($this->cssFile);
    }
  }

  /**
  * Registers a JavaScript file under {@link scriptUrl}.
  * Note that by default, the script file will be rendered at the end of a page to improve page loading speed.
  * @param string $fileName JavaScript file name
  * @param integer $position the position of the JavaScript file. Valid values include the following:
  * <ul>
  * <li>CClientScript::POS_HEAD : the script is inserted in the head section right before the title element.</li>
  * <li>CClientScript::POS_BEGIN : the script is inserted at the beginning of the body section.</li>
  * <li>CClientScript::POS_END : the script is inserted at the end of the body section.</li>
  * </ul>
  */
  private function _registerScriptFile($fileName,$position=CClientScript::POS_END)  {
    $this->_cs->registerScriptFile($this->juiScriptUrl.'/'.$fileName,$position);
  }

  /**
  * Returns the version of this module.
  * @return string the version of this module.
  */
  public function getVersion() {
    return '1.6.1';
  }

  /**
  * Returns the user with the specified id.
  * To handle the case of a user logged in to the Yii default application as
  * admin/admin or demo/demo or a similar scenario where the user is not in the
  * db, we use a dummy user to provide the RBAM user name.
  * @param mixed the user id
  */
  public function getUser($id) {
    $user = CActiveRecord::model($this->userClass)->findByPk($id);

    if (is_null($user) && !Yii::app()->getUser()->isGuest) {
      $user = CActiveRecord::model($this->userClass);
      $user->{$this->userNameAttribute} = Yii::app()->getUser()->id;
    }
    $user->attachBehavior('RbamUserBehavior', 'RbamUserBehavior');

    return $user;
  }

  /**
  * Returns a CMenu item property for the module.
  * Call this function as an item in a list of CMenu items.
  * @param array CMenu item property. Options set here override the defaults.
  * @return array CMenu item(s).
  */
  public function getMenuItem($item=array()) {
    $items = $this->getMenuItems(isset($item['items'])?$item['items']:array());
    unset($item['items']);
    $linkOptions = array_merge(
      array('title'=>Yii::t('RbamModule.rbam','Manage Roles & Assignments')),
      (isset($item['linkOptions'])?$item['linkOptions']:array())
    );
    unset($item['linkOptions']);
    return array_merge(array(
      'label'=>Yii::t('RbamModule.rbam','RBAM'),
      'url'=>array("{$this->baseUrl}/rbam"),
      'linkOptions'=>$linkOptions,
      'items'=>$items
    ),$item);
  }

  /**
  * Returns an array CMenu items for the module.
  * @param array CMenu items. Options set here override the defaults.
  * @return array CMenu items.
  */
  public function getMenuItems($items=array()) {
    $user = Yii::app()->getUser();
    return array_merge(array(
      array(
        'label'=>Yii::t('RbamModule.rbam','Auth Assignments'),
        'url'=>array('authAssignments/index'),
        'active'=>$this->id==='authAssignments',
        'visible'=>$user->checkAccess($this->authAssignmentsManagerRole)
      ),
      array(
        'label'=>Yii::t('RbamModule.rbam','Auth Items'),
        'url'=>array('authItems/index'),
        'active'=>$this->id==='authItems' && $this->action->id!=='generate',
        'visible'=>$user->checkAccess($this->authItemsManagerRole),
        'items'=>array(
          array(
            'label'=>Yii::t('RbamModule.rbam','Create {type}', array('{type}'=>Yii::t('RbamModule.rbam','Role'))),
            'url'=>array('authItems/create', 'type'=>CAuthItem::TYPE_ROLE),
            'active'=>$this->id==='authItems' && $this->action->id==='create' && strpos(Yii::app()->getRequest()->queryString,'type='.CAuthItem::TYPE_ROLE)!==false,
          ),
          array(
            'label'=>Yii::t('RbamModule.rbam','Create {type}', array('{type}'=>Yii::t('RbamModule.rbam','Task'))),
            'url'=>array('authItems/create', 'type'=>CAuthItem::TYPE_TASK),
            'active'=>$this->id==='authItems' && $this->action->id==='create' && strpos(Yii::app()->getRequest()->queryString,'type='.CAuthItem::TYPE_TASK)!==false,
          ),
          array(
            'label'=>Yii::t('RbamModule.rbam','Create {type}', array('{type}'=>Yii::t('RbamModule.rbam','Operation'))),
            'url'=>array('authItems/create', 'type'=>CAuthItem::TYPE_OPERATION),
            'active'=>$this->id==='authItems' && $this->action->id==='create' && strpos(Yii::app()->getRequest()->queryString,'type='.CAuthItem::TYPE_OPERATION)!==false,
          ),
        )
      ),
      array(
        'label'=>Yii::t('RbamModule.rbam','Generate Auth Data'),
        'url'=>array('authItems/generate'),
        'active'=>$this->id==='authItems' && $this->action->id==='generate',
        'visible'=>$this->development && $user->checkAccess($this->rbacManagerRole)
      ),
      array(
        'label'=>Yii::t('RbamModule.initialisation','Re-Initialise RBAC'),
        'url'=>array('rbamInitialise/initialise'),
        'active'=>$this->id==='rbaminitialise',
        'visible'=>$this->development && !empty($this->initialise) && $user->checkAccess($this->rbacManagerRole)
      )
    ), $items);
  }
}