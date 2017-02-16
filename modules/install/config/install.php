<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

require_once dirname(__FILE__).'/../components/DirectoryChecker.php';
DirectoryChecker::check();

$installConfig = array(
  'name'=>'Ygin Installer',
  'language' => 'ru',
  'sourceLanguage' => 'ru_RU',
  'import' => array(
    'application.components.*',
    'ygin.modules.user.models.User',
    'ygin.modules.user.behaviors.password.*',
    'ygin.modules.user.components.DaWebUser',
  ),
  'defaultController' => 'install/default',
  'modules' => array('ygin.install'),
  'pluginsCompile' => true,
  'components'=> array(
    'errorHandler'=>array(
      'errorAction'=>'install/default/error',
    ),
    'session' => array(
      'autoStart' => true,
    ),
    'urlManager'=>array(
      'urlFormat'=>'path',
      'showScriptName' => false,
      'urlSuffix' => '/',
      'caseSensitive' => true,
      'rules'=>array(
        '<controller:\w+>/<id:\d+>'=>'<controller>/view',
        '<controller:\w+>' => '<controller>/index',
        '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
        '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
      ),
    ),
    'authManager'=>array(
      'class' => 'CDbAuthManager',
      'connectionID' => 'db',
      'itemTable'       => 'da_auth_item',
      'itemChildTable'  => 'da_auth_item_child',
      'assignmentTable' => 'da_auth_assignment',
      'defaultRoles'    =>  array('guest'),
    ),
    'log'=>array(
      'routes' => array(
        'install' => array(
          'class' => 'CFileLogRoute',
          'categories' => array('ygin.install'),
          'logFile' => 'install.log',
          /*
          'filter' => array(
            'class' => 'CLogFilter',
            //'logVars' => array('_GET','_POST','_FILES','_COOKIE','_SESSION','_SERVER'),
          ),
          */
        ),
      ),
    ),
  ),
);
$coreConfig = require(dirname(__FILE__) . '/../../../config/core.php');

return CMap::mergeArray($coreConfig, $installConfig);
