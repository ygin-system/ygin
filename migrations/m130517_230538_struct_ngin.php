<?php

class m130517_230538_struct_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("ALTER TABLE `da_object` DROP `id_object_handler`");
    $this->execute("ALTER TABLE `da_object` DROP `id_instance_class`");
    $this->execute("ALTER TABLE `da_object` DROP `seq_start_value`");
    $this->execute("ALTER TABLE `da_object_parameters` CHANGE `field_name` `field_name` VARCHAR(255) COMMENT  'Имя поля в БД'");
    $this->execute("ALTER TABLE `da_object_parameters` CHANGE `name` `widget` VARCHAR(255) COMMENT  'Виджет'");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
