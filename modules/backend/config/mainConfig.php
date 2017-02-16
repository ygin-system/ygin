<?php

// ЭТОТ ФАЙЛ НЕ ДОЛЖЕН МЕНЯТЬСЯ В ПРОЕКТЕ

$adminUrl = 'admin';
// чтобы в каждом маршруте не прописывыать admin и т.о. найти нужный контроллер
$request = new CHttpRequest();
$_SERVER['HTTP_X_REWRITE_URL'] = str_replace('//', '/', str_replace('/'.$adminUrl.'/', '/', $request->getRequestUri()));

$mainConfig = array(
  'name'=>'Engine macro',
  'language' => 'ru',
  'sourceLanguage' => 'ru_RU',
  'defaultController' => 'ygin',
  'homeUrl' => '/'.$adminUrl.'/',
  
  'viewPath' => realpath(dirname(__FILE__).'/../views/'),
    
  'theme' => 'ygin',

  // preloading 'log' component
  'preload'=>array('authManager', 'log', 'yii2Debug'),

  'aliases' => array(
  ),
    
  // autoloading model and component classes
  'import'=>array(
    'application.models.*',
    //'application.components.*',
    'application.controllers.*',
    'application.widgets.*',
    'application.helpers.*',
  ),

  'modules'=>array(
    'ygin.backend',
    'ygin.user',
    'ygin.mail',
    'ygin.menu',
    'ygin.viewGenerator',
  ),
  
  // application components
  'components'=>array(

    'yii2Debug' => array(
      'class' => 'backend.components.Yii2DebugBackend',
      'allowedIPs' => array('192.168.0.*', '127.0.0.1'),
      'enabled' => YII_DEBUG,
    ),

    'format'=>array(
      'timeFormat'=>'H:i:s',
      'dateFormat'=>'d.m.Y',
      'datetimeFormat'=>'d.m.Y H:i:s',
    ),

    'user'=>array(
      'allowAutoLogin' => true,
      'class' => 'user.components.DaWebUser',
      'loginUrl' => array('user/user/login'),
    ),
    'domain' => array(
      'class' => 'ygin.components.DaDomain',
    ),
    
    'authManager'=>array(
      'class' => 'ygin.modules.user.components.DaDbAuthManager',
      'connectionID' => 'db',
      'itemTable'       => 'da_auth_item',
      'itemChildTable'  => 'da_auth_item_child',
      'assignmentTable' => 'da_auth_assignment',
      'defaultRoles'    =>  array('guest'),
    ),

    // настройки по умолчанию для виджетов
    'widgetFactory' => array(
      'class' => 'CWidgetFactory',
      'widgets' => array(
        'BreadcrumbsWidget' => array(
          'separator' => '',
          'tagName' => 'ul',
          'htmlOptions' => array('class' => 'breadcrumb'),
          'encodeLabel' => false,
        ),
      ),
    ),

    'clientScript' => array(
      'corePackages' => require dirname(__FILE__).DIRECTORY_SEPARATOR.'../../../config/packages.php',
    
      'class'=>'ygin.ext.ExtendedClientScript.ExtendedClientScript',
      'combineCss' => true,
      'compressCss' => !YII_DEBUG,
      'combineJs' => true,
      'compressJs' => false, //!YII_DEBUG,
      'jsMinPath' => 'ygin.ext.ExtendedClientScript.jsmin.JSMin',
      'cssMinPath' => 'ygin.ext.ExtendedClientScript.cssmin.cssmin',
    
      'autoRefresh' => YII_DEBUG,
    
      //'excludeCssFiles' => array('yii.debug.toolbar.css'),
    ),
    
    'urlManager'=>array(
      'baseUrl' => '/'.$adminUrl,
      'class' => 'backend.components.BackendUrlManager',
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
    
    'errorHandler'=>array(
      'errorAction'=>'static/error',
    ),
        
    'cache' => array(
      //'class' => 'system.caching.CFileCache',
      'class' => 'system.caching.CDummyCache',
    ),
        
    'log'=>array(
      'class'=>'CLogRouter',
      'routes'=>array(
        'DbProfileLogRoute' => array( // при разработке выводим медленные и повторяющиеся запросы на экран
          'class'=>'ygin.ext.db_profiler.DbProfileLogRoute',
          'countLimit' => 2, // How many times the same query should be executed to be considered inefficient
          'slowQueryMin' => 0.2, // Minimum time for the query to be slow
          'enabled' => false,
        ),
        'CSSlowLogRoute' => array( // долгие и часто повторяющиеся запросы записываем в файл
          'class'=>'ygin.ext.CSSlowLogRoute',
          'logSlow' => 0.2, //log profile entries slower than 3 seconds (you can use decimals here)
          'logFrequent' => 2, //log profile entries which occured more than 3 times
          'logFile' => 'query_slow.log',
        ),

        'backend' => array(
          'class' => 'DaFileLogRoute',
          'levels' => 'info',
          'logFile' => 'backend.log',
          'categories' => 'backend.*',
          'enabled' => true,
        ),
          
        'sql_update' => array(
          'class'=>'ygin.components.SqlLogRoute',
          'logOnlyQuery' => true,
          'includedQueries' => array(
            '~INSERT~',
            '~CREATE~',
            '~RENAME~',
            '~ALTER~',
            '~UPDATE~',
            '~TRUNCATE~',
            '~DELETE~',
            '~DROP~',
          ),
          'excludedQueries' => array(
            '~SHOW CREATE TABLE~',
            '~^SELECT~',
          ),
          'logFile' => 'sql_update.log',
          'enabled' => true,
        ),

        'YiiDebugToolbarRoute' => array(  // при отладке вываливаем всю инфу в тулбар
          'class' => 'backend.components.YiiDebugToolbarRouteBackend',
          'ipFilters' => array('192.168.0.*', '127.0.0.1'),
          'enabled' => false, //YII_DEBUG,
        ),

      ),
      
    ),
  ),

);

$coreConfig = require(dirname(__FILE__).'/../../../config/core.php');
$backendConfig = dirname(__FILE__).'/../../../../protected/config/';
$projectConfig = array();
if (file_exists($backendConfig.'backend.php')) {
  $projectConfig = require($backendConfig.'backend.php');
} else {
  $projectConfig = require($backendConfig.'project.php');
  unset($projectConfig['theme']);
}
$pluginsConfig = array();
if (file_exists(dirname(__FILE__).'/../../../../protected/runtime/plugin-compile.dat')) {
  $pluginsConfig = unserialize(file_get_contents(dirname(__FILE__).'/../../../../protected/runtime/plugin-compile.dat'));
}

// опция, включаяющая дополнительные возможности по управлению полями для разработчиков самой системы ygin
defined('YGIN_DEVELOP') or define('YGIN_DEVELOP', false);

return CMap::mergeArray($coreConfig, $mainConfig, $projectConfig, $pluginsConfig);
