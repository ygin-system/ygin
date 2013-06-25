<?php

class m130409_094600_project_bootstrap extends CDbMigration
{

  public function down()
  {
    return false;
  }

  
  // Use safeUp/safeDown to do migration with transaction
  public function safeUp() {
    $path1 = Yii::getPathOfAlias('ygin.assets.bootstrap');
    $path2 = Yii::getPathOfAlias('application.assets.bootstrap');
    $files = array('/css/bootstrap.min.css', '/css/bootstrap-responsive.min.css', '/js/bootstrap.min.js', '/img/glyphicons-halflings.png', '/img/glyphicons-halflings-white.png');
    foreach($files AS $path)
      HFile::copyFile($path1.$path, $path2.$path);
  }

}