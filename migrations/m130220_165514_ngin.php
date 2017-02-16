<?php

class m130220_165514_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE `da_object` SET `yii_model`='ngin.modules.news.models.News' WHERE `da_object`.`id_object`=502");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false, false, false);
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
