<?php

class m121016_134502_struct_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("ALTER TABLE `pr_comment` CHANGE `id_comment` `id_comment` INT( 8 ) NOT NULL AUTO_INCREMENT");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false);
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
