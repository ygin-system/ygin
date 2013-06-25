<?php

class m130522_175400_backend extends CDbMigration {
  public function safeUp() {
    // переименовываем модуль yiigin в backend в прикладных файлах
    HFile::replaceData(array(
      'YiiginApplication',
      'yiigin',
    ), array(
      'BackendApplication',
      'backend',
    ), Yii::getPathOfAlias('webroot').'/index.php');

    if (file_exists(Yii::getPathOfAlias('application.config').'/yiigin.php')) {
      rename(Yii::getPathOfAlias('application.config').'/yiigin.php', Yii::getPathOfAlias('application.config').'/backend.php');
    }


    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
