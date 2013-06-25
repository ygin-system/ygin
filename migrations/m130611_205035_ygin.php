<?php

class m130611_205035_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE `da_object_parameters` SET `id_object`='ygin.menu', `id_parameter`='3', `id_parameter_type`=2, `sequence`=4, `widget`=NULL, `caption`='Заголовок раздела', `field_name`='caption', `add_parameter`='0', `default_value`=NULL, `not_null`=0, `sql_parameter`=NULL, `is_unique`=0, `group_type`=0, `need_locale`=1, `search`=1, `is_additional`=0, `hint`='Заголовок не виден в меню сайта, но отображается крупно над текстом в самом разделе. Заголовок обычно длиннее названия в меню.' WHERE `da_object_parameters`.`id_object`='ygin.menu' AND `da_object_parameters`.`id_parameter`='3'");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
