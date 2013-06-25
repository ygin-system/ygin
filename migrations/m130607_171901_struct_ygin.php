<?php

class m130607_171901_struct_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("ALTER TABLE `da_localization_element` DROP `id_localization_element`");
    $this->execute("ALTER TABLE `da_localization_element` DROP `id_object`");
    $this->execute("ALTER TABLE `da_localization_element` DROP `id_object_parameter`");
    $this->execute("DROP TABLE `da_localization_element`");
    $this->execute("ALTER TABLE `da_localization_interface` DROP `code`");
    $this->execute("ALTER TABLE `da_localization_interface` DROP `name`");
    $this->execute("DROP TABLE `da_localization_interface`");
    $this->execute("DROP TABLE `da_localization_element_value`");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
