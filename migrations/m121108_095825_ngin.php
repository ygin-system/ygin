<?php

class m121108_095825_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE `da_object` SET `id_object_handler`=NULL, `id_instance_class`=NULL, `yii_model`='banners.models.BannerPlace' WHERE `da_object`.`id_object`=261");
    $this->execute("UPDATE `da_object` SET `id_object_handler`=NULL, `id_instance_class`=NULL, `yii_model`='banners.models.Banner' WHERE `da_object`.`id_object`=260");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false, false, false);
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
