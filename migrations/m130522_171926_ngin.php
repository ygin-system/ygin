<?php

class m130522_171926_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE `da_object` SET `id_object`=43, `name`='SQL', `id_field_order`=NULL, `order_type`=1, `table_name`='yiigin/special/sql', `id_field_caption`=NULL, `object_type`=3, `folder_name`='', `parent_object`=3, `sequence`=5, `use_domain_isolation`=0, `field_caption`='', `yii_model`='' WHERE `da_object`.`id_object`=43");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
