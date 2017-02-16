<?php

class DaWebUser extends CWebUser {

  const ROLE_DEV = 'dev';

  
  /**
   * @var boolean Доступна ли в целом опция запоминания на сайте
   */
  public $remeberAvailable = true;

  /**
   * @var integer Количество часов, в течение которых система будет помнить пользователя. По умолчанию месяц.
   */
  public $durationIfRemeber = 720;
  private $_model = null;

  public function getModel() {
    if ($this->_model === null) {
      $this->_model = User::model()->find(array(
          'condition' => 'id_user = :USER_ID',
          'params' => array(':USER_ID' => $this->id),
      ));
    }
    return $this->_model;
  }
  
  public function getEscapedName() {
    return CHtml::encode($this->getName());
  }

  // TODO - переопределение родительского метода на время пока не будет исправлен баг
  /**
   * Logs in a user.
   *
   * The user identity information will be saved in storage that is
   * persistent during the user session. By default, the storage is simply
   * the session storage. If the duration parameter is greater than 0,
   * a cookie will be sent to prepare for cookie-based login in future.
   *
   * Note, you have to set {@link allowAutoLogin} to true
   * if you want to allow user to be authenticated based on the cookie information.
   *
   * @param IUserIdentity $identity the user identity (which should already be authenticated)
   * @param integer $duration number of seconds that the user can remain in logged-in status. Defaults to 0, meaning login till the user closes the browser.
   * If greater than 0, cookie-based login will be used. In this case, {@link allowAutoLogin}
   * must be set true, otherwise an exception will be thrown.
   * @return boolean whether the user is logged in
   */
  public function login($identity,$duration=0)
  {
    $id=$identity->getId();
    $states=$identity->getPersistentStates();
    if($this->beforeLogin($id,$states,false))
    {
      $this->changeIdentity($id,$identity->getName(),$states);
//      if($duration>0)
//      {
        if($this->allowAutoLogin)
          $this->saveToCookie($duration);
        else
          throw new CException(Yii::t('yii','{class}.allowAutoLogin must be set true in order to use cookie-based authentication.',
            array('{class}'=>get_class($this))));
//      }

      $this->afterLogin(false);
    }
    return !$this->getIsGuest();
  }
  /**
   * Saves necessary user data into a cookie.
   * This method is used when automatic login ({@link allowAutoLogin}) is enabled.
   * This method saves user ID, username, other identity states and a validation key to cookie.
   * These information are used to do authentication next time when user visits the application.
   * @param integer $duration number of seconds that the user can remain in logged-in status. Defaults to 0, meaning login till the user closes the browser.
   * @see restoreFromCookie
   */
  protected function saveToCookie($duration)
  {
    $app=Yii::app();
    $cookie=$this->createIdentityCookie($this->getStateKeyPrefix());
    $cookie->expire=($duration == 0 ? 0 : time()+$duration); // TODO
    $data=array(
      $this->getId(),
      $this->getName(),
      $duration,
      $this->saveIdentityStates(),
    );
    $cookie->value=$app->getSecurityManager()->hashData(serialize($data));
    $app->getRequest()->getCookies()->add($cookie->name,$cookie);
  }
  public function getReturnUrl($defaultUrl = '/') {
    $returnUrl = parent::getReturnUrl($defaultUrl);
    if ($returnUrl == '/index.php') {
      return '/';
    }
    return $returnUrl;
  }
}