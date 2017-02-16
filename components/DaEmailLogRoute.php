<?php

Yii::import('ygin.ext.yii-mail.*');

class DaEmailLogRoute extends CEmailLogRoute {

  /**
   * Данные для авторизации. Если авторизация не нужна то null
   * @var string
   */
  private $_authUser;
  private $_authPassword;
  
  /**
   * Способ отправки. @see PHPMailer::Mail
   * @var string
   */
  private $_mailMethod = 'smtp';
  
  /**
   * Хост, на который будут отсылаться сообщения
   * @var string
   */
  private $_host;
  
  
  public function setAuthUser($authUser) {
    $this->_authUser = $authUser;
  }
  
  public function getAuthUser() {
    return $this->_authUser;
  } 
  
  public function setAuthPassword($authPassword) {
    $this->_authPassword = $authPassword;
  }
  
  public function getAuthPassword() {
    return $this->_authPassword;
  }
  
  public function setMailMethod($mailMethod) {
    $this->_mailMethod = $mailMethod;
  }
  
  public function getMailMethod() {
    return $this->_mailMethod;
  }
  
  public function setHost($host) {
    $this->_host = $host;
  }

  public function getHost() {
    return $this->_host;
  }
  
  public function processLogs($logs) {
    if (empty($logs)) {
      return;
    }
    $message='';
    foreach($logs as $log)
      $message.=$this->formatLogMessage($log[0],$log[1],$log[2],$log[3]);
    $message=wordwrap($message,70);
    $subject=$this->getSubject();
    if($subject===null)
      $subject=Yii::t('yii','Application Log');
      
    $this->sendEmail($this->getEmails(),$subject,$message);
  }
  
  private function log($msg) {
    $format = '{time} {message}'.PHP_EOL;
    $msg = strtr($format, array('{time}' => date('Y.m.d H:i:s', time()), '{message}' => $msg));
    Yii::log($msg, CLogger::LEVEL_ERROR, 'application.sendMail.error');
    return;

    $fileName = Yii::getPathOfAlias('application.runtime').'/'.__CLASS__.'Error.log';
    $format = '{time} {message}'.PHP_EOL;
    $f = fopen($fileName, 'a');
    fwrite($f, strtr($format, array('{time}' => date('Y.m.d H:i:s', time()), '{message}' => $msg)));
    fclose($f);

  }
  
  public function sendEmail($emails, $subject, $message) {
    if ($this->getHost() == null) return;
    /**
     * @var $mailer YiiMail
     */
    $mailer = Yii::createComponent(array(
      'class' => 'YiiMail',
      'transportType' => $this->getMailMethod(),
      'transportOptions' => array(
        'host' => $this->getHost(),
        'port' => 465,
        'encryption' => 'ssl'
      ),
      'logging' => false,
    ));
    $mailer->init();
    $mailerTransport = $mailer->getTransport();

    if ($this->getAuthUser() !== null) { //нужна авторизация на сервере
      $mailerTransport
          ->setUsername(trim($this->getAuthUser()))
          ->setPassword(trim($this->getAuthPassword()));
    } else {
      $mailerTransport
          ->setUsername(null)
          ->setPassword(null);
    }

    $mailMessage = new YiiMailMessage();
    $mailMessage->setBody($message, 'text/plain', 'utf-8');
    $mailMessage->setFrom($this->getSentFrom());
    $mailMessage->setSubject($subject);
    $mailMessage->setTo($emails);
    $errorMessage = false;
    try {
      if (!$mailer->send($mailMessage, $failures)) {
        $errorMessage = sprintf("Ошибка при отправке почты:\n %s", print_r($failures, true));
      }
    } catch(Exception $e) {
      $errorMessage = $e->getMessage();
    }
    if ($errorMessage) $this->log($errorMessage);
  }
}
