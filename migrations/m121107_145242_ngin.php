<?php

class m121107_145242_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE `da_object` SET `id_object_handler`=NULL, `id_instance_class`=NULL, `yii_model`='photogallery.models.Photogallery' WHERE `da_object`.`id_object`=500");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false, false, false);
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
