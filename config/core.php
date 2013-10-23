<?php

YiiBase::setPathOfAlias('ygin', realpath(dirname(__FILE__).'/../'));
YiiBase::setPathOfAlias('ngin', realpath(dirname(__FILE__).'/../')); // TODO придется оставить на какое-то время для совместимости.

//Название хоста, для отправки отчетов об ошибках
$errorSubjectHost = '';
if (isset($_SERVER['HTTP_HOST'])) {
  //Если пришло в punicode
  if (strpos($_SERVER['HTTP_HOST'], 'xn--') !== false) {
    YiiBase::import('ygin.lib.IDNA', true);
    $idna = new Net_IDNA_php4();
    $errorSubjectHost = $idna->decode($_SERVER['HTTP_HOST']);
  } else {
    $errorSubjectHost = $_SERVER['HTTP_HOST'];
  }
} else {
  $errorSubjectHost =realpath(dirname(__FILE__).'/../../');
}

return array(
  'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'../../protected',

  'aliases' => array(
    'temp' => 'webroot.temp',
    'xupload' => 'ygin.ext.xupload',
    'fileUpload' => 'ygin.components.fileUpload',
  ),
  
  'preload'=>array('log'),
  
  // autoloading model and component classes
  'import'=>array(
    'ygin.helpers.*',
    'ygin.components.*',
    'ygin.interface.*',
  ),
  
  'components' => array(
     'session' => array(
       'autoStart' => false,
       'cookieParams' => array(
         'timeout' => '7200',
       ),
     ),
     'db' => array(
       'nullConversion' => PDO::NULL_EMPTY_STRING,
     ),
     'log'=>array(
       'class'=>'CLogRouter',
       'routes' => array(
         'email_error' => array(  // при отключенной отладке (на хостинге) отправлять все сообщения об ошибках на e-mail
           'class' => 'ygin.components.DaEmailLogRoute',
           'levels' => 'error, warning',
           'filter' => array(
             'class' => 'ygin.components.DaLogFilter',
             'ignoreCategories' => array(
               'exception.CHttpException.404',
               'exception.DaHttpException.*',
             ),
           ),
           'subject' => 'Ошибка на сайте ('.$errorSubjectHost.')',
           'enabled' => YII_DEBUG == false,
         ),
         'mailErrorLog' => array(  // ошибки при отправке почты
           'class' => 'DaFileLogRoute',
           'categories'=>'application.sendMail.error',
           'logFile' => 'mail_error_log.log',
         ),
         'errorLog' => array(  // все ошибки (кроме 404) записываем в лог. Также в лог попадают переменные окружения (см. logVars)
           'class' => 'CFileLogRoute',
           'levels' => 'error, warning',
           'logFile' => 'error_log.log',
           'filter' => array(
             'class' => 'ygin.components.DaLogFilter',
             'ignoreCategories' => array(
               'exception.CHttpException.404',
               'exception.DaHttpException.*',
               'application.sendMail.error',
             ),
             'logVars' => array('_GET','_POST','_FILES','_COOKIE','_SESSION','_SERVER'),
           ),
         ),
         'loginLog' => array(  // логируем все попытки авторизоваться
           'class' => 'DaFileLogRoute',
           'levels' => 'info',
           'categories'=>'application.login.*',
           'logFile' => 'login.log',
           'filter' => array(
             'class' => 'CLogFilter',
             'logVars' => array(),
           ),
         ),
       ),
    ),
  ),

);
