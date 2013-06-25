<?php

class m121029_114119_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE `da_object_parameters` SET `default_value` = 'SiteModuleTemplate::getIdDefaultTemplate();' WHERE `da_object_parameters`.`id_object` =100 AND `da_object_parameters`.`id_parameter` =15 LIMIT 1");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false);
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
