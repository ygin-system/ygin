<?php
class LoginAction extends CAction {
  public function run() {
    $model = BaseFormModel::newModel('LoginForm');
    $modelClass = get_class($model);
    $ajaxId = isset($_POST['login-widget-form']) ?'login-widget-form' : 'login-form';
    if (isset($_POST['ajax']) && $_POST['ajax']===$ajaxId) {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
    if (isset($_POST[$modelClass])) {
      $model->attributes = $_POST[$modelClass];
      if ($model->validate() && $model->login()) {
        Yii::log('Успешная авторизация под логином '.$model->username, CLogger::LEVEL_INFO, 'application.login.success');
        $this->controller->redirect(Yii::app()->user->returnUrl);
      } else {
        Yii::log('Ошибка авторизации (логин='.$model->username.')', CLogger::LEVEL_INFO, 'application.login.error');
        Yii::app()->user->setFlash('user_login_error', CHtml::errorSummary($model, ' '));
      }
    }
    
    $view = '/login';
    if (Yii::app()->isBackend) $view = 'backend.views.auth';
    if ($view != null) {
      $this->controller->render($view, array('model'=>$model));
    } else {
      $this->controller->redirect(Yii::app()->user->returnUrl);
    }
  }
}