<?php
/**
 * ECommentsBaseWidget class file.
 *
 * @author Dmitry Zasjadko <segoddnja@gmail.com>
 * @link https://github.com/segoddnja/ECommentable
 */

/**
 * Base class for allmodule widgets
 *
 * @version 1.0
 * @package Comments module
 */
Yii::import('zii.widgets.jui.CJuiWidget');

class ECommentsBaseWidget extends CJuiWidget {     
  /**
   * @var class for unwatching comments
   */
  public $classUnWatchCommentView = "unWatch";
  /**
   * @var is object BlogPost
   */
  public $isObjectBlog = false;
  /**
   * @var is owner blog or not
   */
  public $isOwnerBlog = false;
  /**
   * @var id attribute
   */
  public $id = 'commentsUID';
  /**
   * @var model for displaying comments
   */
  public $model;

  /**
   * If only registered users can post comments
   * @var registeredOnly
   */
  public $registeredOnly = false;
  
  /**
   * Use captcha validation on posting
   * @var registeredOnly
   */
  public $useCaptcha = false;
  
  /**
   * Action for posting comments, where add comment form is submited
   * @var postCommentAction
   */
  public $postCommentAction = 'comments/comment/postComment';
  
  /**
   * @var array
   */
  protected $_config;
  
  
  private $_assetsPath = null;
  private $_basePath = null;
  
  /**
   * Получает путь, где лежит описание класса
   * @return string
   */
  public function getBasePath() {
    if ($this->_basePath === null) {
      $class = new ReflectionClass(get_class($this));
      $this->_basePath = dirname($class->getFileName());
    }
    return $this->_basePath;
  }
  
  private function getThemePath($fileName) {
    if (($theme=Yii::app()->getTheme()) !== null) {
      $viewPath = $theme->getViewPath().'/'.get_class($this).'/assets/';
      if (is_file($viewPath.$fileName)) {
        return $viewPath;
      }
    }
    return null;
  }
  
  /**
   * Путь к файлам ресурсов (css, js). В конце присутствует DIRECTORY_SEPARATOR
   * @return string
   */
  public function getAssetsPath() {
    if ($this->_assetsPath === null) {
      $this->_assetsPath = $this->getBasePath().DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR;
    }
    return $this->_assetsPath;
  }
  
  public function registerCssFile($cssFile, $path=null) {
    if ($path == null) $path = $this->getThemePath($cssFile);
    if ($path == null) $path = $this->getAssetsPath();
    $cs = Yii::app()->clientScript;
    $cs->registerCssFile(CHtml::asset($path.$cssFile));
  }
  public function registerJsFile($jsFile, $path=null) {
    if ($path == null) $path = $this->getThemePath($jsFile);
    if ($path == null) $path = $this->getAssetsPath();
    $cs = Yii::app()->clientScript;
    $cs->registerScriptFile(CHtml::asset($path.$jsFile));
  }
  
  /**
   * Initializes the widget.
   */
  public function init() {
    parent::init();
    //get comments module
    $commentsModule = Yii::app()->getModule('comments');
    //get model config for comments module
    $this->_config = $commentsModule->getModelConfig();
    if(count($this->_config) > 0) {
      $this->registeredOnly = isset($this->_config['registeredOnly']) ? $this->_config['registeredOnly'] : $this->registeredOnly;
      $this->useCaptcha = isset($this->_config['useCaptcha']) ? $this->_config['useCaptcha'] : $this->useCaptcha;
      $this->postCommentAction = isset($this->_config['postCommentAction']) ? $this->_config['postCommentAction'] : $this->postCommentAction;
    }
    $this->registerScripts();
  }

  /**
   * Registers the JS and CSS Files
   */
  protected function registerScripts() {
    //$assets = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('comments') . '/assets', false, -1, YII_DEBUG);
    //$cs = Yii::app()->getClientScript();
    //$cs->registerScriptFile($assets.'/comments.js', CClientScript::POS_HEAD);
    $assets  = $this->getAssetsPath(); 
    Yii::app()->clientScript->addDependResource('comment.css', array(
      $assets.'cross.gif',
      $assets.'repl.gif',
    ));
    $this->registerJsFile('comments.js');
    $this->registerCssFile('comment.css');
    //$cs->registerScriptFile($assets . '/yiicomments.js');
  }
  
  /*
   * Create new comment model and initialize it with owner data
   * @return EComments comment
   */
  protected function createNewComment() {
    $comment = BaseActiveRecord::newModel('CommentYii');
    $comment->id_object = $this->model->getIdObject();
    $comment->id_instance = $this->model->getIdInstance();
    return $comment;
  }
  
}

