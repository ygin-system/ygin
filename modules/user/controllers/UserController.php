<?php

class UserController extends Controller {
  
  public $defaultAction = 'logout';
  
  public function actions() {
    return array(
      'login'  => 'LoginAction',
      'logout' => 'LogoutAction',
    );
  }
  
  public function filters() {
    return array(
      'accessControl',
    );
  }
  
  public function accessRules(){
    return array(
      array('allow',
        'actions'=>array('login'),
        'users'=>array('?'),
      ),
      array('allow',
        'actions'=>array('logout'),
        'users'=>array('*'),
      ),
      array('deny',
        'actions'=>array('login'),
        'users' => array('@'),
        'deniedCallback' => array($this, 'redirectToHome'),
      ),
      array('deny',
        'users' => array('*'),
      ),
    );
  }

  public function redirectToHome() {
    Yii::app()->getRequest()->redirect(Yii::app()->createUrl(''));
  }
}