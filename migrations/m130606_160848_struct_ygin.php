<?php

class m130606_160848_struct_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("ALTER TABLE `da_object_parameter_type` ADD `sql_type` VARCHAR(255) COMMENT  'sql тип'");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
