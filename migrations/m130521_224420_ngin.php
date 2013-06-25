<?php

class m130521_224420_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE da_object_parameters SET field_name=NULL WHERE field_name='-'");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
