<?php

class m130724_100320_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE `da_object` SET `id_field_order`='7', `order_type`=1 WHERE `da_object`.`id_object`='ygin-menu'");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
