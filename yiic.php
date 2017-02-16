<?php

// /yiic/migrate/create/test2
// /yiic/migrate/create/test2/migrationPath/application.migrations/

if (!class_exists('YiiBase')) {
  require_once(dirname(__FILE__).'/yii/YiiBase.php');
}
require_once(dirname(__FILE__).'/components/DaConsoleApplication.php');

class Yii extends YiiBase {
}

// Переопределяющий конфиг файл на локальном хосте
if (!isset($local)) {
  $localConfig = dirname(__FILE__).'/../protected/config/local.php';
  $local = null;
  if (file_exists($localConfig)) {
    $local = require($localConfig);
  }
}

$config = require(dirname(__FILE__).'/config/console.php');
if ($local != null) $config = CMap::mergeArray($config, $local);
if (!in_array(PHP_SAPI, array('cli', 'cgi', 'cgi-fcgi'))) {
  $request = new CHttpRequest();
  $arr = explode('/', substr($request->getRequestUri(), 1));
  $_SERVER['argv'] = array();
  foreach($arr AS $k => $v) {
    if (trim($v) == '') continue;
    $_SERVER['argv'][$k] = str_replace('%20', ' ', $v);
  }
}
if (!isset($_SERVER['SCRIPT_FILENAME'])) {
  $_SERVER['SCRIPT_FILENAME'] = __FILE__;
}

//require_once(dirname(__FILE__).'/yii/yiic.php');

// yiic.php from framework

// fix for fcgi
defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));

defined('YII_DEBUG') or define('YII_DEBUG',true);

//require_once(dirname(__FILE__).'/yii.php');


if(isset($config))
{
  $app=Yii::createApplication('DaConsoleApplication', $config);
  $app->commandRunner->addCommands(YII_PATH.'/cli/commands');
}
else
  $app=Yii::createConsoleApplication(array('basePath'=>dirname(__FILE__).'/cli'));

$env=@getenv('YII_CONSOLE_COMMANDS');
if(!empty($env))
  $app->commandRunner->addCommands($env);

$app->getModule('scheduler'); //TODO (перенести отсюда) инициализируем модуль планировщик

$app->run();
