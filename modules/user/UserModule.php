<?php

class UserModule extends DaWebModuleAbstract {

  const ROUTE_LOGOUT = 'user/cabinet/logout';
  const ROUTE_LOGIN = 'user/cabinet/login';
  const ROUTE_REGISTER = 'user/cabinet/register';
  const ROUTE_PROFILE = 'user/cabinet/profile';
  const ROUTE_RECOVER = 'user/cabinet/recover';
  const ROUTE_VIEW = 'user/cabinet/view';
  const ROUTE_ADMIN_LOGIN = 'user/user/login';
  const ROUTE_ADMIN_LOGOUT = 'user/user/logout';
  
  /** Чтобы иметь возможность нормально переопределять */
  public $routeLogout = self::ROUTE_LOGOUT;
  public $routeLogin = self::ROUTE_LOGIN;
  public $routeRegister = self::ROUTE_REGISTER;
  public $routeRecover = self::ROUTE_RECOVER;
  public $routeProfile = self::ROUTE_PROFILE;
  public $routeView = self::ROUTE_VIEW;
  
  /**
   * Роут для редиректа пользователя после регистрации
   * @var string
   */
  public $redirectRouteAfterRegister;
  /**
   * Нужно ли сразу авторизовывать пользователя после регистрации
   * @var boolean
   */
  public $immediatelyAuthorization = true;
  
  /**
   * @var boolean Доступность личного кабинета
   */
  public $cabinetEnabled = false;
  
  public $defaultController = "user";
  /**
   * @var int Тип события "Восстановление пароля"
   */
  public $idEventTypeRecover;
  /**
   * @var int Подписчик на событие "Восстановление пароля"
   */
  public $idEventSubscriberRecover;
  /**
   * @var int Тип события "Регистрация пользователя"
   */
  public $idEventTypeRegister;

  public function init() {
    $this->setImport(array(
        $this->getId().'.models.*',
        $this->getId().'.components.*',
        $this->getId().'.behaviors.password.*',
        $this->getId().'.components.auth.models.*',
    ));
    
    if ($this->cabinetEnabled) {
      $this->setUrlRules(array(
        'login'         => $this->routeLogin,
        'logout'        => $this->routeLogout,
        'register'      => $this->routeRegister,
        'profile'       => $this->routeProfile,
        'recover'       => $this->routeRecover,
        'user/<id:\d+>' => $this->routeView,
      ));
    }
    
    if (Yii::app()->isBackend) {
      $ext = Yii::createComponent('user.components.RbamExtension', $this);
      Yii::app()->backend->addExtension($ext);
      //для админки надо поменять роуты
      $this->setUrlRules(array(
        'login' => self::ROUTE_ADMIN_LOGIN,
        'logout' => self::ROUTE_ADMIN_LOGOUT,
      ));
      Yii::app()->user->loginUrl = array(self::ROUTE_ADMIN_LOGIN);
    }
  }

}
