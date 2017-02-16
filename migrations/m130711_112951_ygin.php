<?php

class m130711_112951_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("DELETE FROM `da_reference_element` WHERE `da_reference_element`.`id_reference_element_instance`='47'");
    $this->execute("UPDATE `da_reference_element` SET `id_reference`='31', `id_reference_element`=3, `value`='Контроллер', `image_element`=NULL, `id_reference_element_instance`='19' WHERE `da_reference_element`.`id_reference_element_instance`='19'");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`='20', `id_parameter`='67', `id_parameter_type`=2, `sequence`=6, `widget`=NULL, `caption`='Таблица / Контроллер / Ссылка', `field_name`='table_name', `add_parameter`=NULL, `default_value`=NULL, `not_null`=0, `sql_parameter`=NULL, `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='В зависимости от типа объекта, поле хранит различные значения. При стандартном - имя таблицы, при контроллере - алиас класса' WHERE `da_object_parameters`.`id_object`='20' AND `da_object_parameters`.`id_parameter`='67'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`='ygin-menu' AND `da_object_parameters`.`id_parameter`='9'");
    $this->execute("DELETE FROM  `da_object_parameter_type` WHERE  `da_object_parameter_type`.`id_parameter_type` =18");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
