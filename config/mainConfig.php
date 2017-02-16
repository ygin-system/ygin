<?php

// ЭТОТ ФАЙЛ НЕ ДОЛЖЕН МЕНЯТЬСЯ В ПРОЕКТЕ

$modules = array(
//  'ygin.ygin',
  'ygin.menu',
  'ygin.user',
  'ygin.mail',
);
if (YII_DEBUG) {
  $modules['gii'] = array(
      'class'=>'system.gii.GiiModule',
      'password'=>'123',
      'newFileMode' => 0777,
      'newDirMode' => 0777,
      'generatorPaths' => array(
        'application.gii',   // псевдоним пути
        'ygin.gii',
      ),
      // If removed, Gii defaults to localhost only. Edit carefully to taste.
      'ipFilters'=>array('192.168.0.*','127.0.0.1'),
  );
  $modules[] = 'ygin.override';
  $modules[] = 'ygin.viewGenerator';
}

$mainConfig = array(
  'sourceLanguage' => 'ru_RU',
  'defaultController' => 'static/page',
  'homeUrl' => '/',
  
  'aliases' => array(
    'widgets' => realpath(dirname(__FILE__).'/../widgets/'),
  ),
    
  // autoloading model and component classes
  'import'=>array(
    'application.models.*',
    'application.components.*',
    'application.controllers.*',
    'application.widgets.*',
    'application.helpers.*',
  ),

  'preload' => array(
    'yii2Debug',
  ),

  'modules'=>$modules,
    
  // application components
  'components'=>array(

    'yii2Debug' => array(
      'class' => 'ygin.ext.yii2-debug.Yii2Debug',
      'allowedIPs' => array('192.168.0.*', '127.0.0.1'),
      'enabled' => YII_DEBUG,
    ),

    'authManager'=>array(
      'class' => 'CDbAuthManager',
      'connectionID' => 'db',
      'itemTable'       => 'da_auth_item',
      'itemChildTable'  => 'da_auth_item_child',
      'assignmentTable' => 'da_auth_assignment',
      'defaultRoles'    =>  array('guest'),
    ),

    'assetManager' => array(
//      'linkAssets' => true,
    ),
  
    'user'=>array(
      'allowAutoLogin' => true,
      'class' => 'user.components.DaWebUser',
      'loginUrl' => array('user/cabinet/login'),
      'autoRenewCookie' => true,
    ),
    'menu' => array(
      'class' => 'menu.components.DaMenu',
    ),
    'domain' => array(
      'class' => 'ygin.components.DaDomain',
    ),
    
    // настройки по умолчанию для виджетов
    'widgetFactory' => array(
      'class' => 'CWidgetFactory',
      'widgets' => array(
        'BreadcrumbsWidget' => array(
          'separator' => ' <span class="divider">/</span>',
          'tagName' => 'ul',
          'htmlOptions' => array('class' => 'breadcrumb'),
        ),
      ),
    ),
    
    'clientScript' => array(
      'corePackages' => require dirname(__FILE__).DIRECTORY_SEPARATOR.'packages.php',
    
      'class'=>'ygin.ext.ExtendedClientScript.ExtendedClientScript',
      'combineCss' => true,
      'compressCss' => !YII_DEBUG,
      'combineJs' => true,
      'compressJs' => !YII_DEBUG,
      'jsMinPath' => 'ygin.ext.ExtendedClientScript.jsmin.JSMin',
      'cssMinPath' => 'ygin.ext.ExtendedClientScript.cssmin.cssmin',
    
      'autoRefresh' => YII_DEBUG,
      //'excludeCssFiles' => array('yii.debug.toolbar.css'),
    ),
    
    'urlManager'=>array(
      'urlFormat'=>'path',
      'showScriptName' => false,
      'urlSuffix' => '/',
      'caseSensitive' => true,
      'rules'=>array(
        'gii'=>'gii',
        'gii/<controller:\w+>'=>'gii/<controller>',
        'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',
           
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
        'sql_update_site' => array(
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
          'logFile' => 'sql_update_site.log',
          'enabled' => YII_DEBUG,
        ),
        'YiiDebugToolbarRoute' => array(  // при отладке вываливаем всю инфу в тулбар
          'class' => 'ygin.ext.yii-debug-toolbar.YiiDebugToolbarRoute',
          'ipFilters' => array('192.168.0.*', '127.0.0.1'),
          'enabled' => false, //YII_DEBUG,
        ),
      ),
      
    ),
  ),

);

$coreConfig = require(dirname(__FILE__).'/core.php');
$projectConfig = require(dirname(__FILE__).'/../../protected/config/project.php');
$rules = array();
if (isset($projectConfig['components']['urlManager']['rules'])) {
  $rules['components']['urlManager']['rules'] = $projectConfig['components']['urlManager']['rules'];
  unset($projectConfig['components']['urlManager']['rules']);
}
$pluginsConfig = array();
if (file_exists(dirname(__FILE__).'/../../protected/runtime/plugin-compile.dat')) {
  $pluginsConfig = unserialize(file_get_contents(dirname(__FILE__).'/../../protected/runtime/plugin-compile.dat'));
}

return CMap::mergeArray($coreConfig, $rules, $mainConfig, $projectConfig, $pluginsConfig);
