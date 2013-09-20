<?php
/**
* Comments module class file.
*
* @author Dmitry Zasjadko <segoddnja@gmail.com>
* @link https://github.com/segoddnja/ECommentable
* @version 1.0
* @package Comments module
*
*/
class CommentsModule extends DaWebModuleAbstract {

  public $defaultController = 'comment';
  
  /*
   * captcha action route
   */
  const CAPTCHA_ACTION_ROUTE = '/comments/comment/captcha';
  
  /*
   * delete comment action route
   */
  const DELETE_ACTION_ROUTE = 'comments/comment/delete';
  
  /*
   * approve comment action route
   */
  const APPROVE_ACTION_ROUTE = 'comments/comment/approve';
  
  /**
   * Commentable models
   * @var array commentableModels
   */
  public $commentableModels = array();
  
  /**
   * Action for posting comments, where add comment form is submited
   * @var postCommentAction
   */
  public $postCommentAction;
  
  /**
   * Settings for User model, used in application
   * @var userSettings
   */
  public $userConfig;
  
  public $modelClassMap = array();
  /**
   * Default config for model
   * @var _defaultModelConfig
   */
  protected $_defaultModelConfig = array(
    //only registered users can post comments
    'registeredOnly' => false,
    'useCaptcha' => false,
    //allow comment tree
    'allowSubcommenting' => true,
    //display comments after moderation
    'premoderate' => false,
    //action for postig comment
    'postCommentAction' => 'comments/comment/postComment',
    //super user condition(display comment list in admin view and automoderate comments)
    'isSuperuser'=>'false',
    //order direction for comments
    'orderComments'=>'ASC',
    //settings for comments page url
    'pageUrl'=>null,
    //send notice about comment
    'sendNoticeAboutComment' => true,
  );

  public function init() {
    // import the module-level models and components
    $this->setImport(array(
      'comments.models.*',
    ));
  }
      
  /*
   * Returns settings for model. Model can be CActiveRecord instance or string.
   * If there is no model settings, then return null
   * @param mixed $model
   * @return mixed
   */
  public function getModelConfig() {
    return $this->_defaultModelConfig;
  }

  /*
   * Sets default config for models
   * @param array $config
   */
  public function setDefaultModelConfig($config) {
    if(is_array($config)) {
      $this->_defaultModelConfig = array_merge($this->_defaultModelConfig, $config);
    }
  }
  
  /**
   * Вызывается после добавления комментария
   *
   * @param CommentYii $comment
   */
  public function onNewComment($comment) {
    $event = new CEvent($comment);
    $this->raiseEvent('onNewComment', $event);
  }
  /**
   * Вызывается после изменения комментария
   *
   * @param CommentYii $comment
   */
  public function onUpdateComment($comment)
  {
    $event = new CEvent($comment);
    $this->raiseEvent('onUpdateComment', $event);
  }
  /**
   * Вызывается после удаления комментария
   *
   * @param CommentYii $comment
   */
  public function onDeleteComment($comment)
  {
    $event = new CEvent($comment);
    $this->raiseEvent('onDeleteComment', $event);
  }
}
