<?php
class FeedbackWidget extends DaWidget {

  public function run() {
    Yii::app()->user->setReturnUrl(Yii::app()->request->url);
    
    $feedback = BaseActiveRecord::newModel('Feedback');
    $this->render('feedback', array('model' => $feedback));
  }
}