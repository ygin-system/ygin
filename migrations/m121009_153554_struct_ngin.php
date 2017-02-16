<?php

class m121009_153554_struct_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("ALTER TABLE `pr_question` CHANGE `name` `name` VARCHAR(255) NOT NULL");
    $this->execute("ALTER TABLE `pr_question` CHANGE `question` `question` LONGTEXT NOT NULL");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false);
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
