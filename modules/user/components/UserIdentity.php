<?php
class UserIdentity extends CUserIdentity {
	
	const ERROR_USER_BLOCKED = 50;
	
  private $_id;
  
  public function getId() {
    return $this->_id;
  }
  
  public function authenticate() {
	  $userName = mb_strtolower($this->username);
	  $user = User::model()->find('LOWER(name) = ?', array($userName));
	  
	  if ($user === null) {
	    $this->errorCode = self::ERROR_USERNAME_INVALID;
	  } elseif ($user->isBlocked()) {
	  	$this->errorCode = self::ERROR_USER_BLOCKED;
  	} elseif (!$user->validatePassword($this->password)) {
	    $this->errorCode = self::ERROR_PASSWORD_INVALID;
	  } else {
	    $this->_id = $user->id_user;
	    $this->username = $user->name;
	    $this->errorCode = self::ERROR_NONE;
	  }
 		return $this->errorCode == self::ERROR_NONE;
	}
}