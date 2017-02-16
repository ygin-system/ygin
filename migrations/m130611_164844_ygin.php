<?php

class m130611_164844_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("DELETE FROM da_search_data WHERE id_object=51 AND id_instance='3'");
    $this->execute("DELETE FROM `da_job` WHERE `da_job`.`id_job`='3'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=51 AND id_instance='2'");
    $this->execute("DELETE FROM `da_job` WHERE `da_job`.`id_job`='2'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=51 AND id_instance='10'");
    $this->execute("DELETE FROM `da_job` WHERE `da_job`.`id_job`='10'");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
