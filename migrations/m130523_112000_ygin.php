<?php

class m130523_112000_ygin extends CDbMigration {
  public function safeUp() {
    $files = HFile::findFiles(Yii::getPathOfAlias('application'));
    $files = array_merge($files,
      HFile::findFiles(Yii::getPathOfAlias('application').'/../themes/')
    );
    foreach($files AS $file)
      @HFile::replaceData('ngin.', 'ygin.', $file);
    @HFile::replaceData('/../ngin/assets/', '/../ygin/assets/', Yii::getPathOfAlias('webroot').'/themes/business/views/layouts/main.php');

    Yii::app()->attachEventHandler('onEndRequest', array($this, 'renameNgin'));

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }

  public function renameNgin(CEvent $event) {
    $path1 = HFile::normalizePath(Yii::getPathOfAlias('ygin'));
    $path2 = str_replace(array('/ngin', '/usr/files/projects/www/'), array('/ygin', '/usr/www/'), Yii::getPathOfAlias('ygin'));
    if ($path1 == $path2) return;
    rename($path1, $path2);
    YiiBase::setPathOfAlias('ygin', realpath(dirname(__FILE__).'/../'));

    // переименовываем ngin в ygin в прикладных файлах
    HFile::replaceData('/ngin/', '/ygin/', Yii::getPathOfAlias('webroot').'/index.php');
  }

}
