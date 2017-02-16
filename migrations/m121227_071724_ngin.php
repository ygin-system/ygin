<?php

class m121227_071724_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE `da_object` SET `id_object_handler`=NULL, `id_instance_class`=NULL WHERE `da_object`.`id_object`=503");
    $this->execute("DELETE FROM `da_php_script_type` WHERE `da_php_script_type`.`id_php_script_type`=1022");
    $this->execute("DELETE FROM `da_php_script_type` WHERE `da_php_script_type`.`id_php_script_type`=1023");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`=31, `id_parameter`=286, `id_parameter_type`=10, `sequence`=8, `name`='ngin.yiigin.DomainLocalizationVisualElement', `caption`='Доступные локализации', `field_name`='engine/admin/element/abstract/DomainLocalization.php', `add_parameter`=2, `default_value`=NULL, `not_null`=0, `sql_parameter`='DomainLocalization', `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`=NULL WHERE `da_object_parameters`.`id_object`=31 AND `da_object_parameters`.`id_parameter`=286");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false, false, false);
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
