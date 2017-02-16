<?php

class m130717_113252_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("DELETE FROM `da_object_view_column` WHERE `da_object_view_column`.`id_object_view_column`='108'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`='80' AND `da_object_parameters`.`id_parameter`='340'");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`='80', `id_parameter`='339', `id_parameter_type`=2, `sequence`=5, `widget`=NULL, `caption`='Алиас', `field_name`='file_path', `add_parameter`=NULL, `default_value`=NULL, `not_null`=1, `sql_parameter`=NULL, `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='' WHERE `da_object_parameters`.`id_object`='80' AND `da_object_parameters`.`id_parameter`='339'");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
