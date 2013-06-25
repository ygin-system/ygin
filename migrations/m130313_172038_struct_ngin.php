<?php

class m130313_172038_struct_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("ALTER TABLE `pr_open_id_provider` DROP `icon`");
    $this->execute("ALTER TABLE `pr_open_id_provider` DROP `search`");
    $this->execute("ALTER TABLE `pr_open_id_provider` DROP `name`");
    $this->execute("DROP TABLE `pr_open_id_provider`");
    $this->execute("ALTER TABLE `pr_open_id_account` DROP `provider`");
    $this->execute("ALTER TABLE `pr_open_id_account` DROP `id_user`");
    $this->execute("ALTER TABLE `pr_open_id_account` DROP `account`");
    $this->execute("DROP TABLE `pr_open_id_account`");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
