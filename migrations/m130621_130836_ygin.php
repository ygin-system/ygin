<?php

class m130621_130836_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE `da_object_parameters` SET `id_object`='21', `id_parameter`='81', `id_parameter_type`=2, `sequence`=8, `widget`=NULL, `caption`='Параметр', `field_name`='add_parameter', `add_parameter`='0', `default_value`=NULL, `not_null`=0, `sql_parameter`=NULL, `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='Поле хранит значения, применяемые в различных ситуациях разработчиками' WHERE `da_object_parameters`.`id_object`='21' AND `da_object_parameters`.`id_parameter`='81'");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
