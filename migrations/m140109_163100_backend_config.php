<?php

class m140109_163100_backend_config extends CDbMigration
{

  public function down()
  {
    return false;
  }

  
  // Use safeUp/safeDown to do migration with transaction
  public function safeUp() {
    $configPath = Yii::getPathOfAlias('application.config').'/backend.php';
    if (!file_exists($configPath)) {
      $data = '<?php

// За основу берем проектный конфиг
$projectConfig = include dirname(__FILE__).\'/project.php\';

// Можно например переопределить контроллер по умолчанию, или сделать любые другие модификации в конфиг бэкэнд-приложения
// $projectConfig[\'defaultController\'] = \'yiigin/default\';

return $projectConfig;
';
      file_put_contents($configPath, $data);
      @chmod($configPath, 0777);
    }
  }

}