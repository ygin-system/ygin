<?php
class CabinetController extends Controller {
  public $defaultAction = 'profile';
  
  public function actions() {
    return CMap::mergeArray(parent::actions(), array(
      'login'  => 'LoginAction',
      'logout' => 'LogoutAction',
    ));
  }
  
  public function filters() {
    return array(
      'accessControl',
    );
  }
  
  public function accessRules(){
    return array(
      array('allow',
        'actions'=>array('register', 'recover'),
        'users'=>array('?'),
      ),
      array('allow',
        'actions'=>array('profile'),
        'users'=>array('@'),
      ),
      array('allow',
        'actions'=>array('login', 'recovery'),
        'users'=>array('?'),
      ),
      array('allow',
        'actions'=>array('logout', 'captcha', 'view'),
        'users'=>array('*'),
      ),
      array('deny',
        'users' => array('*'),
      ),
    );
  }
  
  public function performAjaxValidation($model, $ajaxFormId) {
    if (isset($_POST['ajax']) && $_POST['ajax']===$ajaxFormId) {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  
  protected function getRedirectRouteAfterRegister() {
    $module = Yii::app()->getModule('user');
    if (!empty($module->redirectRouteAfterRegister)) {
      return $module->redirectRouteAfterRegister;
    }
    if ($module->immediatelyAuthorization) {
      return $module->routeProfile;
    }
    return $module->routeLogin;
  }
  
  public function actionRegister() {
    $model = BaseActiveRecord::newModel('User', 'register');
    $modelClass = get_class($model);
    $this->performAjaxValidation($model, 'register-form');
  
    if (isset($_POST[$modelClass])) {
      $model->attributes = $_POST[$modelClass];
      //Создаем indentity раньше сохранения модели
      //т.к. после сохранения поле user_password измениться на хеш
      $identity = new UserIdentity($model->name, $model->user_password);
      $model->onAfterSave = array($this, 'sendRegisterMessage');
      if ($model->save()) {
        //если разрешено сразу авторизовать пользователя
        if (Yii::app()->getModule('user')->immediatelyAuthorization) {
          //загружаем модель пользователя
          $identity->authenticate();
          //Сразу авторизуем пользователя
          Yii::app()->user->login($identity);
          Yii::app()->user->setFlash('registerSuccess', 'Регистрация успешно завершена.');
        } else {
          Yii::app()->user->setFlash('registerSuccess', 'Регистрация успешно завершена. Теперь вы можете войти на сайт через форму авторизации.');
        }
        
        $this->redirect(Yii::app()->createUrl($this->getRedirectRouteAfterRegister()));
      }
    }
    $this->render('/register', array('model' => $model));
  }
  public function sendRegisterMessage(CEvent $event) {
    /* @var User $$user */
    $user = $event->sender;
    $message = $this->renderPartial('/register_email', array('user' => $user), true);
    Yii::app()->notifier->addNewEvent(
      $this->module->idEventTypeRegister,
      $message
    );
  }
  public function actionRecover() {
    $model = BaseFormModel::newModel('RecoverForm');
    $modelClass = get_class($model);
    $this->performAjaxValidation($model, 'recover-form');
    if (isset($_POST[$modelClass])) {
      $model->attributes = $_POST[$modelClass];
      if ($model->validate()) {
        $model->onRecover = array($this, 'sendRecoverMessage');
        $model->recover();
        Yii::app()->user->setFlash('recoverSuccess', 'Новый пароль от вашего аккаунта отправлен вам на e-mail.');
        $this->refresh();
      }
    }
    $this->render('/recover', array('model' => $model));
  }
  
  public function sendRecoverMessage(CEvent $event) {
    /* @var RecoverForm $recoverForm */
    $recoverForm = $event->sender;
    $message = $this->renderPartial('/recoveryMessage', array('recoverForm' => $recoverForm), true);
    Yii::app()->notifier->addNewEvent(
      $this->module->idEventTypeRecover,
      $message,
      $this->module->idEventSubscriberRecover,
      $recoverForm->getUserModel()->mail
    )->sendNowLastAdded();
  }
  
  public function actionView($id) {
    $model = BaseActiveRecord::model('User')->findByPk($id);
    if ($model === null) {
      $this->throw404Error();
    }
    $this->render('/view', array('model' => $model));
  }
  
  public function actionProfile() {
    $model = Yii::app()->user->getModel();
    $model->scenario = 'profile';
    $modelClass = get_class($model);
    $this->performAjaxValidation($model, 'profile-form');
  
    if (isset($_POST[$modelClass])) {
      $model->attributes = $_POST[$modelClass];
      if ($model->save()) {
        Yii::app()->user->setFlash('profileSuccess', 'Профиль успешно изменен.');
        $this->refresh();
      }
    }
    //Затираем пароль, чтобы он не отображался в инпуте
    $model->user_password = '';
    $this->render('/profile', array('model' => $model));
  }
  
  protected function beforeAction($action) {
    $this->urlAlias = $action->id == 'view' ? 'user' : $action->id;
    return parent::beforeAction($action);
  }
}