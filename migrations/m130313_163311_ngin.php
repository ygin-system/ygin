<?php

class m130313_163311_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='39'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=34 AND `da_object_parameters`.`id_parameter`=39");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
