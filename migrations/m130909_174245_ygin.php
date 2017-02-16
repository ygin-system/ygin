<?php

class m130909_174245_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE `da_object` SET `yii_model`='shop.models.Product' WHERE `da_object`.`id_object`='511' AND `yii_model` IS NULL");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
