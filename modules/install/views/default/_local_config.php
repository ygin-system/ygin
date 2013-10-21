<?php
/** @var DbSettings $dbSettings */
?>
<?php echo "<?php\n"; ?>
/**
 * Локальная переопределяющая конфигурация
 */

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

return array(

  'modules'=>(!YII_DEBUG ? array() : array(
    'gii'=>array(
      'password' => '123',
    ),
  )),

  'components' => array(
    'db' => array(
      'connectionString' => '<?php echo $dbSettings->getConnectionString(); ?>',
      'username' =>  '<?php echo $dbSettings->user; ?>',
      'password' => '<?php echo $dbSettings->password; ?>',
      'emulatePrepare' => true,
      'charset' => 'utf8',
      'schemaCachingDuration'=>3600,
      'enableProfiling' => true,
      'enableParamLogging' => true,
    ),

    'clientScript' => array(
      'combineCss' => true,
      'combineJs' => true,
    ),

    'log' => array(
      'routes' => array(
        /*
         * Роут для отправки сообщений об ошибках на почту,
         * позволяет при отключенной отладке (на хостинге) отправлять все сообщения об ошибках на e-mail
         */
        /*
        'email_error' => array( //
          'emails' => 'admin@site.com', // кому
          'sentFrom' => 'admin@site.com', //от кого
          'authUser => 'user', //пользователь для авторизации на smtp
          'authPassword' => 'pass', //пароль для авторизации на smtp
          'enabled' => YII_DEBUG == false,
        ),
        */
      ),
    ),
  ),
);


