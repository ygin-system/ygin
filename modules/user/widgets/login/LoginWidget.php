<?php
class LoginWidget extends CWidget {
  public $view = 'loginWidget';
  public function run() {
    $model = BaseFormModel::newModel('LoginForm');
    Yii::app()->user->setReturnUrl(Yii::app()->request->url);
    
    if (Yii::app()->user->hasFlash('user_login_error')) {
      $this->widget('AlertWidget', array(
        'title' => 'Авторизация не удалась',
        'type' => 'error',
        'message' => Yii::app()->user->getFlash('user_login_error'),
      ));
    }
    $this->render($this->view, array('model' => $model));
  }
  
}