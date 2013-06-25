<?php

class m130524_013012_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE `da_object_parameters` SET `caption`='Обязательное', `not_null`=0 WHERE `da_object_parameters`.`id_object`=21 AND `da_object_parameters`.`id_parameter`=84");
    $this->execute("UPDATE `da_object_parameters` SET `not_null`=0 WHERE `da_object_parameters`.`id_object`=21 AND `da_object_parameters`.`id_parameter`=156");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false, false, false);
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
