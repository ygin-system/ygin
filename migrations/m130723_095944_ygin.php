<?php

class m130723_095944_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE `da_object_parameters` SET `add_parameter`='-1' WHERE `da_object_parameters`.`id_object`='ygin-menu' AND `da_object_parameters`.`id_parameter`='7'");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
