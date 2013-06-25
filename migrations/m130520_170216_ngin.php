<?php

class m130520_170216_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE `da_object_view_column` SET `id_object_view_column`=5, `id_object_view`=3, `id_object`=21, `caption`='Виджет', `order_no`=3, `id_object_parameter`=78, `id_data_type`=2, `field_name`='widget', `handler`=NULL, `visible`=1 WHERE `da_object_view_column`.`id_object_view_column`=5");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
