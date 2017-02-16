<?php

class m130304_105600_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE `da_object` SET `id_instance_class`=NULL WHERE `da_object`.`id_object`=509");
    $this->execute("DELETE FROM `da_php_script_type` WHERE `da_php_script_type`.`id_php_script_type`=1025");
    $this->execute("UPDATE `da_object` SET `id_instance_class`=NULL WHERE `da_object`.`id_object`=511");
    $this->execute("DELETE FROM `da_php_script_type` WHERE `da_php_script_type`.`id_php_script_type`=1026");
    $this->execute("DELETE FROM `da_php_script_type` WHERE `da_php_script_type`.`id_php_script_type`=1035");
    $this->execute("DELETE FROM `da_php_script_type` WHERE `da_php_script_type`.`id_php_script_type`=1033");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false, false, false);
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
