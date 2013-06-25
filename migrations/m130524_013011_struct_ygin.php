<?php

class m130524_013011_struct_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("ALTER TABLE `da_object_parameters` CHANGE `not_null` `not_null` TINYINT(1) default '1' COMMENT  'Обязательное'");
    $this->execute("ALTER TABLE `da_object_parameters` CHANGE `is_unique` `is_unique` TINYINT(1) COMMENT  'Уникальное'");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false, false, false);
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
