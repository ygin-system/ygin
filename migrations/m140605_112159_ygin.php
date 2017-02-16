<?php

class m140605_112159_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE `da_object` SET `folder_name`='content/vitrine' WHERE `id_object`='520'");
    $this->execute("DELETE FROM da_auth_item_child WHERE parent = 'editor' AND child IN ('edit_object_520', 'delete_object_520' , 'create_object_520')");
    $this->execute("INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('editor', 'edit_object_520')");
    $this->execute("INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('editor', 'delete_object_520')");
    $this->execute("INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('editor', 'create_object_520')");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
