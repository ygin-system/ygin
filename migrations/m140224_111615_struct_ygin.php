<?php

class m140224_111615_struct_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("ALTER TABLE `da_object_view` ADD `description` LONGTEXT COMMENT  'Описание представления'");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
