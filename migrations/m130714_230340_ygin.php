<?php

class m130714_230340_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE da_search_data SET id_object = 'ygin-menu' WHERE id_object='100'");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
