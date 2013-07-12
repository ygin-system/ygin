<?php

class m130708_174249_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE `da_system_parameter` SET `id_group_system_parameter`=1 WHERE `da_system_parameter`.`id_system_parameter`='6'");
    $this->execute("UPDATE `da_system_parameter` SET `id_group_system_parameter`=1 WHERE `da_system_parameter`.`id_system_parameter`='31'");
    $this->execute("UPDATE `da_system_parameter` SET `id_group_system_parameter`=1 WHERE `da_system_parameter`.`id_system_parameter`='32'");
    $this->execute("UPDATE `da_system_parameter` SET `id_group_system_parameter`=1 WHERE `da_system_parameter`.`id_system_parameter`='101'");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
