<?php

class m130423_121920_struct_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("ALTER TABLE  `da_object_parameters` CHANGE  `name`  `name` VARCHAR( 120 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  'Имя свойства в системе'");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
