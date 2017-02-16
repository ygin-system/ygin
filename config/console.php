<?php

$mainConfig = array(
  'import' => array(
    'ygin.behaviors.*',
    'ygin.models.*',
    'ygin.models.object.*',
  ),
  'commandMap'=>array(
      'migrate'=>array(
          'class'=>'ygin.cli.commands.DaMigrateCommand',
          'migrationPath'=>'ygin.migrations',
          'migrationTable'=>'da_migration',
          //'connectionID'=>'db',
          //'templateFile'=>'application.migrations.template',
          'interactive' => false,
      ),
  ),
  'modules' => array(
    'scheduler' => array(
      'class' => 'ygin.modules.scheduler.SchedulerModule',
    ),
    'mail' => array(
      'class' => 'ygin.modules.mail.MailModule',
    ),
  ),
  'components' => array(
    'log' => array(
      'routes' => array(
        'migrate' => array(
          'class' => 'CFileLogRoute',
          'levels' => 'info',
          'categories' => 'command.migrate',
          'logFile' => 'migrate.log',
        ),
      ),
    ),
  ),
);

$projectConfig = array();
if (file_exists(dirname(__FILE__).'/../../protected/config/console.php')) {
  $projectConfig = require(dirname(__FILE__).'/../../protected/config/console.php');
} else {
  $config = require(dirname(__FILE__).'/../../protected/config/project.php');
  if (isset($config['components']['db'])) {
    $projectConfig['components']['db'] = $config['components']['db'];
  }
//  unset($projectConfig['modules'], $projectConfig['theme'], $projectConfig['plugins'], $projectConfig['models']);
}
$coreConfig = require(dirname(__FILE__).'/core.php');
return CMap::mergeArray($coreConfig, $mainConfig, $projectConfig);
