<?php
/**
 * ECommentsListWidget class file.
 *
 * @author Dmitry Zasjadko <segoddnja@gmail.com>
 * @link https://github.com/segoddnja/ECommentable
 */

/**
 * Widget for view comments for current model
 *
 * @version 1.0
 * @package Comments module
 */
Yii::import('ygin.modules.comments.widgets.ECommentsBaseWidget');
class ECommentsListWidget extends ECommentsBaseWidget {   

  private $_uniqueId = null;

  /**
   * @var boolean allowSubcommenting
   */
  public $allowSubcommenting = true;
  
  /**
   * @var boolean adminMode
   */
  public $adminMode = false;
  
  public $disableAddComments = false;
  
  private $updateCommentUrl = '/comments/comment/updateComment';
  
  
  /**
   * Initializes the widget.
   */

  public function init() {
    parent::init();
    if(count($this->_config) > 0) {
      $this->allowSubcommenting = isset($this->_config['allowSubcommenting']) ? $this->_config['allowSubcommenting'] : $this->allowSubcommenting;
      if($this->_config['isSuperuser'] !== '') {
        $this->adminMode = $this->evaluateExpression($this->_config['isSuperuser']);
      }
    }
  }

  public function getUniqueId() {
    if ($this->_uniqueId === null) {
      $this->_uniqueId = time()*rand(0, 10000);
    }
    return $this->_uniqueId;
  }

  public function run() {
    $newComment = $this->createNewComment();
    $comments = $newComment->getCommentsTree();
    $this->render('eCommentsListWidget', array(
      'comments' => $comments,
      'newComment' => $newComment,
      'count' => $newComment->getCountComments($newComment->id_object, $newComment->id_instance),
    ));
    $options = CJavaScript::encode(array(
      'updateCommentUrl' => $this->updateCommentUrl,
      'isGuest' => Yii::app()->user->isGuest,
    ));
    $js = "jQuery('#{$this->id}').commentsList($options);";
    Yii::app()->getClientScript()->registerScript(__CLASS__.'#'.$this->id, $js,  CClientScript::POS_READY);
    Yii::app()->getClientScript()->registerScript(__CLASS__.'h#'.$this->id, "commentHightlight();", CClientScript::POS_READY);
  }
}
