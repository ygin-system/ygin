<?php

class m130312_094709_struct_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("ALTER TABLE `da_permissions` DROP `id_permission`");
    $this->execute("ALTER TABLE `da_permissions` DROP `id_group`");
    $this->execute("ALTER TABLE `da_permissions` DROP `id_object`");
    $this->execute("ALTER TABLE `da_permissions` DROP `id_object_parameter`");
    $this->execute("ALTER TABLE `da_permissions` DROP `id_permission_type`");
    $this->execute("ALTER TABLE `da_permissions` DROP `sql_condition`");
    $this->execute("DROP TABLE `da_permissions`");
    $this->execute("ALTER TABLE `da_user_permissions` DROP `id_user_permissions`");
    $this->execute("ALTER TABLE `da_user_permissions` DROP `id_permission`");
    $this->execute("ALTER TABLE `da_user_permissions` DROP `sql_parameter`");
    $this->execute("DROP TABLE `da_user_permissions`");
    $this->execute("ALTER TABLE `da_groups` DROP `name`");
    $this->execute("ALTER TABLE `da_groups` DROP `id_group`");
    $this->execute("DROP TABLE `da_groups`");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
