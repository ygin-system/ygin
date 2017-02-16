<?php

class m130607_155511_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE `da_object_parameters` SET `is_unique`=1 WHERE `da_object_parameters`.`id_object`='ygin.menu' AND `da_object_parameters`.`id_parameter`='127'");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
