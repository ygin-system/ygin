<?php

class m121101_150836_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE `da_php_script_type` SET `id_php_script_type`=401, `file_path`='engine/process_class/MenuProcessGlobal.php', `class_name`='MenuProcessGlobal', `description`='MenuProcessGlobal', `id_php_script_interface`=12 WHERE `da_php_script_type`.`id_php_script_type`=401");
    $this->execute("UPDATE `da_php_script_type` SET `id_php_script_type`=404, `file_path`='engine/process_class/UserProcessGlobal.php', `class_name`='UserProcessGlobal', `description`='UserProcessGlobal', `id_php_script_interface`=12 WHERE `da_php_script_type`.`id_php_script_type`=404");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false, false, false);
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
