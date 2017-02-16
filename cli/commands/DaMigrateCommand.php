<?php
Yii::import('system.cli.commands.MigrateCommand');
class DaMigrateCommand extends MigrateCommand {
  public function beforeAction($action,$params) {
    ob_start();
    return parent::beforeAction($action,$params);
  }
  public function afterAction($action, $params, $exitCode = 0) {
    $content = ob_get_clean();
    echo $content;
    Yii::log($content, CLogger::LEVEL_INFO, 'command.migrate');
    return parent::afterAction($action, $params, $exitCode);
  }
}