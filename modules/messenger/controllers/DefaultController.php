<?php
class DefaultController extends Controller {
  public function actionGetMessages() {
    $messages = Message::model()->unread(Yii::app()->user->id, $this->module->expiredInterval)->findAll();
    $types = array(
      Message::TYPE_INFO => 'info',
      Message::TYPE_ERROR => 'error',
      Message::TYPE_SUCCESS => 'success',
    );
    $result = array();
    foreach ($messages as $message) {
      $result[] = array(
        'id'   => $message->primaryKey,
        'text' => $message->text,
        'type' => $types[(int)$message->type],
      	'sender' => $message->sender,
      );
    }
    echo CJSON::encode($result);
  }
  
  public function actionReadMessage() {
    if (!($id = Yii::app()->request->getPost('id'))) {
      throw new CHttpException(400, 'Bad request.');
    }
    if (!($model = Message::model()->findByPk($id))) {
      throw new CHttpException(404, 'Not found.');
    }
    $model->markAsRead(Yii::app()->user->id);
    echo CJSON::encode(array('result' => true));
  }
}