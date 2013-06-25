<?php

class m130618_155228_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("DELETE FROM da_search_data WHERE id_object=80 AND id_instance='1011'");
    $this->execute("DELETE FROM `da_php_script_type` WHERE `da_php_script_type`.`id_php_script_type`='1011'");
    $this->execute("DELETE FROM da_search_data WHERE id_object='86' AND id_instance='8'");
    $this->execute("DELETE FROM `da_php_script_interface` WHERE `da_php_script_interface`.`id_php_script_interface`=8");
    $this->execute("DELETE FROM da_search_data WHERE id_object='29' AND id_instance='11'");
    $this->execute("DELETE FROM `da_group_system_parameter` WHERE `da_group_system_parameter`.`id_group_system_parameter`=11");
    $this->execute("DELETE FROM da_search_data WHERE id_object='29' AND id_instance='6'");
    $this->execute("DELETE FROM `da_group_system_parameter` WHERE `da_group_system_parameter`.`id_group_system_parameter`=6");
    $this->execute("DELETE FROM da_search_data WHERE id_object=30 AND id_instance='4'");
    $this->execute("DELETE FROM `da_system_parameter` WHERE `da_system_parameter`.`id_system_parameter`='4'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=30 AND id_instance='33'");
    $this->execute("DELETE FROM `da_system_parameter` WHERE `da_system_parameter`.`id_system_parameter`='33'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=30 AND id_instance='3'");
    $this->execute("DELETE FROM `da_system_parameter` WHERE `da_system_parameter`.`id_system_parameter`='3'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=30 AND id_instance='30'");
    $this->execute("DELETE FROM `da_system_parameter` WHERE `da_system_parameter`.`id_system_parameter`='30'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=30 AND id_instance='8'");
    $this->execute("DELETE FROM `da_system_parameter` WHERE `da_system_parameter`.`id_system_parameter`='8'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=30 AND id_instance='9'");
    $this->execute("DELETE FROM `da_system_parameter` WHERE `da_system_parameter`.`id_system_parameter`='9'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=30 AND id_instance='10'");
    $this->execute("DELETE FROM `da_system_parameter` WHERE `da_system_parameter`.`id_system_parameter`='10'");
    $this->execute("DELETE FROM da_search_data WHERE id_object='29' AND id_instance='7'");
    $this->execute("DELETE FROM `da_group_system_parameter` WHERE `da_group_system_parameter`.`id_group_system_parameter`=7");
    $this->execute("DELETE FROM da_search_data WHERE id_object=30 AND id_instance='20'");
    $this->execute("DELETE FROM `da_system_parameter` WHERE `da_system_parameter`.`id_system_parameter`='20'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=30 AND id_instance='21'");
    $this->execute("DELETE FROM `da_system_parameter` WHERE `da_system_parameter`.`id_system_parameter`='21'");
    $this->execute("DELETE FROM da_search_data WHERE id_object='29' AND id_instance='3'");
    $this->execute("DELETE FROM `da_group_system_parameter` WHERE `da_group_system_parameter`.`id_group_system_parameter`=3");
    $this->execute("DELETE FROM `da_auth_item_child` WHERE parent='dev' AND child='edit_object_29'");
    $this->execute("DELETE FROM `da_auth_item_child` WHERE parent='dev' AND child='delete_object_29'");
    $this->execute("DELETE FROM `da_auth_item_child` WHERE parent='dev' AND child='list_object_29'");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
