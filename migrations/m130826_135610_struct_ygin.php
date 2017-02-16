<?php

class m130826_135610_struct_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("ALTER TABLE  `da_object_parameters` ADD  `visible` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT  '1'");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
