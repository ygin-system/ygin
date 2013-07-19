<?php

class m130717_113251_struct_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("ALTER TABLE `da_php_script_type` DROP `class_name`");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
