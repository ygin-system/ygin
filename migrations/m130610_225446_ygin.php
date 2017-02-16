<?php

class m130610_225446_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='598'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`='103' AND `da_object_parameters`.`id_parameter`='598'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='599'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`='ygin.menu' AND `da_object_parameters`.`id_parameter`='599'");
    $this->execute("DELETE FROM da_search_data WHERE id_object='22' AND id_instance='16'");
    $this->execute("DELETE FROM `da_object_parameter_type` WHERE `da_object_parameter_type`.`id_parameter_type`=16");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
