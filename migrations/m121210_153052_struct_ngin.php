<?php

class m121210_153052_struct_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("ALTER TABLE `da_users` DROP `id_group`");
    $this->execute("ALTER TABLE `da_users` CHANGE `mail` `mail` VARCHAR(255) NOT NULL");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false, false, false);
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
