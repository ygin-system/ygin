<?php
/**
* Comment controller class file.
*
* @author Dmitry Zasjadko <segoddnja@gmail.com>
* @link https://github.com/segoddnja/ECommentable
* @version 1.0
* @package Comments module
*
*/
class CommentController extends Controller {
  const EVENT_TYPE_NEW_COMMENT = 50;
  public $defaultAction = 'admin';
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout='//layouts/column1';
  
  /**
   * @return array action filters
   */
  public function filters() {
    return array(
      'accessControl', // perform access control for CRUD operations
      'ajaxOnly + PostComment, Delete, Approve',
    );
  }
      
  /**
   * Specifies the access control rules.
   * This method is used by the 'accessControl' filter.
   * @return array access control rules
   */
  public function accessRules(){
    return array(
      array('allow',
        'actions'=>array('updateComment', 'countUnwatchCommentView', 'setStatusDeleteComment', 'setStatusApproveComment'),
        'users'=>array('@'),
      ),
      array('allow',
      'actions'=>array('postComment', 'captcha', 'view'),
      'users'=>array('*'),
      ),
      array('allow',
      'actions'=>array('admin', 'delete', 'approve'),
      'users'=>array('admin'),
      ),
      array('deny',  // deny all users
      'users'=>array('*'),
      ),
    );
  }

  /**
   * Deletes a particular model.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id) {
    // we only allow deletion via POST request
    $result = array('deletedID' => $id);
    if($this->loadModel($id)->setDeleted())
        $result['code'] = 'success';
    else
        $result['code'] = 'fail';
    echo CJSON::encode($result);
  }
      
  /**
  * Approves a particular model.
  * @param integer $id the ID of the model to be approve
  */
  public function actionApprove($id) {
    // we only allow deletion via POST request
    $result = array('approvedID' => $id);
    if($this->loadModel($id)->setApproved()) {
      $result['code'] = 'success';
    } else {
      $result['code'] = 'fail';
    }
    echo CJSON::encode($result);
  }

  /**
   * Manages all models.
   */
  public function actionAdmin() {
    $model= BaseActiveRecord::newModel('CommentYii', 'search');
    $model->unsetAttributes();  // clear any default values
    $className = get_class($model);
    if(isset($_GET[$className])) {
      $model->attributes=$_GET[$className];
    }
    $this->render('admin',array(
      'model'=>$model,
    ));
  }
      
  public function actionPostComment() {
    $comment = BaseActiveRecord::newModel('CommentYii');
    $className = get_class($comment);
    if(isset($_POST[$className]) && Yii::app()->request->isAjaxRequest) {
      $comment->attributes = $_POST[$className];
      $comment->comment_date = time();
      $comment->moderation = $comment->config['premoderate']
                             ? CommentYii::STATUS_PENDING
                             : CommentYii::STATUS_APPROVED;
      $comment->id_parent = $comment->id_parent == 0 ? null : $comment->id_parent;
      Yii::app()->getModule('comments')
        ->getEventHandlers('onNewComment')
        ->insertAt(0, array($this,'sendMessage'));
      if($comment->save()) {
        return $this->getSuccessResultData($comment);
      }
      return $this->getFailResultData($comment);
    }
  }
  
  public function getSuccessResultData($comment) {
    $result = array();
    $result['code'] = 'success';
    $this->beginClip("list");
    $this->widget('comments.widgets.ECommentsListWidget', array(
        'model' => $comment->ownerModel,
    ));
    $this->endClip();
    
    $this->beginClip('form');
    $this->widget('comments.widgets.ECommentsFormWidget', array(
        'model' => $comment->ownerModel,
    ));
    $this->endClip();
    $result['list'] = $this->clips['list'];
    $result['form'] = $this->clips['form'];
    echo CJSON::encode($result);
  }
  
  public function getFailResultData($comment) {
    $result = array();
    $result['code'] = 'fail';
    $this->beginClip('form');
    $this->widget('comments.widgets.ECommentsFormWidget', array(
        'model' => $comment->ownerModel,
        'validatedComment' => $comment,
    ));
    $this->endClip();
    $result['form'] = $this->clips['form'];
    echo CJSON::encode($result);
  }

  /**
   * @deprecated
   * @param null $idObj
   * @param null $idInst
   */
  public function actionUpdateComment($idObj = null, $idInst = null) {
    $idObject = ($idObj == null) ? (int)Yii::app()->request->getPost('idObject') : $idObj ;
    $idInstance = ($idInst == null) ? (int)Yii::app()->request->getPost('idInstance') : $idInst;
    $sql = "INSERT INTO pr_statistic_new_comment(id_object, id_instance, id_user, date_show)
            VALUES (?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE date_show = ?";
    Yii::app()->db->createCommand($sql)->execute(array($idObject, $idInstance, Yii::app()->user->id, time(), time()));
  }
  
  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = BaseActiveRecord::model('CommentYii')->findByPk($id);
    if($model===null)
      throw new CHttpException(404,'The requested page does not exist.');
    return $model;
  }
  
  // рендерим лист комментов
  private function renderCommentsList($model) {
    $this->beginClip("list");
    $this->widget('comments.widgets.ECommentsListWidget', array(
        'model' => $model,
    ));
    $this->endClip();
    return $this->clips['list'];
  }
  
  public function actionView($idObject, $idInstance) {
    if (!isset(Yii::app()->getModule('comments')->modelClassMap[$idObject])) {
      throw new CHttpException(400, 'Bad request');
    }
    $modelClass = Yii::app()->getModule('comments')->modelClassMap[$idObject];
    $model = CActiveRecord::model($modelClass)->findByPk($idInstance);
    $result['comments'] = $this->renderCommentsList($model);
    echo CJSON::encode($result);
  }
  
  /**
   * выводим в листе новостей или постов количество непросмотренных комментариев
   * @deprecated
   */
  public function actionCountUnwatchCommentView() {
    $idObject = (int) Yii::app()->request->getQuery('idObject');
    $idInstances =  Yii::app()->request->getQuery('id');
    $data = array();
    $sql = "SELECT nComment.id_instance instance, count(id_comment) countNewComments
            FROM pr_statistic_new_comment nComment LEFT JOIN pr_comment comment
            ON comment.id_instance = nComment.id_instance
              AND comment.id_object = nComment.id_object
              AND comment.comment_date >= nComment.date_show
            WHERE nComment.id_user = :idUser
              AND nComment.id_object = :idObject
              AND nComment.id_instance in (" . implode(',', $idInstances) . ")
              AND comment.moderation = ".CommentYii::STATUS_APPROVED."
            GROUP BY 1;";
    $query = Yii::app()->db->createCommand($sql);
    if ($query) {
      $result = $query->queryAll(true, array(
        ':idUser' => Yii::app()->user->id,
        ':idObject' => $idObject,
      ));
      foreach($result as $row) {
        $data[$row["instance"]] = $row["countNewComments"];
      }
    }
    $sql = "SELECT id_instance as id, count(id_comment) as count
            FROM pr_comment
            WHERE id_object = :idObject
              AND id_instance in (" . implode(',', $idInstances) . ")
              AND moderation = ".CommentYii::STATUS_APPROVED."
            GROUP BY 1";
    $query = Yii::app()->db->createCommand($sql);
    if ($query) {
      $res = $query->queryAll(true, array(
        ':idObject' => $idObject,
      ));
      foreach($res as $row) {
        if (!isset($data[$row['id']])) {
          $data[$row['id']] = $row['count'];
        }
      }
    }
    
    foreach($idInstances as $idInstance) {
      if (!isset($data[$idInstance])) {
        $data[$idInstance] = 0;
      }
    }
    
    echo CJSON::encode($data);
  }
  
  //Ставим статус удаленного коммента
  public function actionSetStatusDeleteComment() {
    $result = array();
    $idComment = (int) Yii::app()->request->getPost('idComment');
    $comment = BaseActiveRecord::model('CommentYii')->findByPk($idComment);

    /*if ($comment != null &&
        Yii::app()->user->checkAccess('deleteComment', array('comment' => $comment))) {
     */
    if ($comment != null && $comment->isOwnerComment()) {
       $comment->setDeleted();
       $result['code'] = 'success';
       return $this->getSuccessResultData($comment);
    }
    return $this->getFailResultData($comment);
  }
  
  //Ставим статус утвержденного коммента
  public function actionSetStatusApproveComment() {
    $result = array();
    $idComment = (int) Yii::app()->request->getPost('idComment');
    $comment = BaseActiveRecord::model('CommentYii')->findByPk($idComment);
  
    if ($comment != null &&
        Yii::app()->user->checkAccess('approveComment', array('comment' => $comment))) {
      $comment->setApproved();
      return $this->getSuccessResultData($comment);
    }
    return $this->getFailResultData($comment);
  }
  
  
  public function sendMessage($event) {
    $model = $event->sender;
    if ($model->getIsNewRecord()) {
      Yii::app()->notifier->addNewEvent(
        self::EVENT_TYPE_NEW_COMMENT,
        $this->renderPartial('/comment/message',array(
          'model' => $model,
        ), true),
        null,
        null,
        $model->primaryKey
      );
    }
  }
  

  
}
