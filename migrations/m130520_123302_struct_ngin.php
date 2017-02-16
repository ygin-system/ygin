<?php

class m130520_123302_struct_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("ALTER TABLE  `da_object_parameters` CHANGE  `caption`  `caption` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  'Название'");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
