<?php

class m130710_142133_struct_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("ALTER TABLE  `da_object` CHANGE  `parent_object`  `parent_object` VARCHAR( 255 ) NULL DEFAULT NULL COMMENT  'Родитель'");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
