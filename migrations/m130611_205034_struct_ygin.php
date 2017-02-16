<?php

class m130611_205034_struct_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("ALTER TABLE `da_menu` CHANGE `zagolovok` `caption` VARCHAR(255) COMMENT  'Заголовок раздела'");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
