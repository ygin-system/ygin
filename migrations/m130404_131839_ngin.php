<?php

class m130404_131839_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE `da_object_parameters` SET `name`='menu.yiigin.widgets.menuName.MenuNameWidget' WHERE `da_object_parameters`.`id_object`=100 AND `da_object_parameters`.`id_parameter`=2");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
