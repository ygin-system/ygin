<?php

class m130328_151605_struct_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("ALTER TABLE `da_php_script_type` ADD `active` TINYINT(1) NOT NULL default '1' COMMENT  'Активен'");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
