<?php
class FeedbackWidget extends DaWidget {

  public function run() {
    Yii::app()->user->setReturnUrl(Yii::app()->request->url);
    
    $feedback = Feedback::model();
    $this->render('feedback', array('model' => $feedback));
  }
}