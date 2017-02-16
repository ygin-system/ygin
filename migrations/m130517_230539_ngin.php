<?php

class m130517_230539_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=20 AND `da_object_parameters`.`id_parameter`=61");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=20 AND `da_object_parameters`.`id_parameter`=60");
    $this->execute("DELETE FROM `da_php_script_type` WHERE `da_php_script_type`.`id_php_script_type`=444");
    $this->execute("DELETE FROM `da_php_script_type` WHERE `da_php_script_type`.`id_php_script_type`=445");
    $this->execute("DELETE FROM `da_php_script_type` WHERE `da_php_script_type`.`id_php_script_type`=446");
    $this->execute("DELETE FROM `da_php_script_type` WHERE `da_php_script_type`.`id_php_script_type`=448");
    $this->execute("DELETE FROM `da_php_script_type` WHERE `da_php_script_type`.`id_php_script_type`=449");
    $this->execute("DELETE FROM `da_php_script_type` WHERE `da_php_script_type`.`id_php_script_type`=450");
    $this->execute("DELETE FROM `da_php_script_type` WHERE `da_php_script_type`.`id_php_script_type`=453");
    $this->execute("DELETE FROM `da_php_script_type` WHERE `da_php_script_type`.`id_php_script_type`=458");
    $this->execute("DELETE FROM `da_php_script_type` WHERE `da_php_script_type`.`id_php_script_type`=459");
    $this->execute("DELETE FROM `da_php_script_type` WHERE `da_php_script_type`.`id_php_script_type`=460");
    $this->execute("DELETE FROM `da_php_script_type` WHERE `da_php_script_type`.`id_php_script_type`=1016");
    $this->execute("DELETE FROM `da_php_script_type` WHERE `da_php_script_type`.`id_php_script_type`=1018");
    $this->execute("DELETE FROM `da_php_script_type` WHERE `da_php_script_type`.`id_php_script_type`=1019");
    $this->execute("DELETE FROM `da_php_script_type` WHERE `da_php_script_type`.`id_php_script_type`=1020");
    $this->execute("DELETE FROM `da_php_script_type` WHERE `da_php_script_type`.`id_php_script_type`=1021");
    $this->execute("DELETE FROM `da_php_script_type` WHERE `da_php_script_type`.`id_php_script_type`=1024");
    $this->execute("DELETE FROM `da_php_script_interface` WHERE `da_php_script_interface`.`id_php_script_interface`=13");
    $this->execute("DELETE FROM `da_php_script_interface` WHERE `da_php_script_interface`.`id_php_script_interface`=5");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=20 AND `da_object_parameters`.`id_parameter`=71");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`=21, `id_parameter`=80, `id_parameter_type`=2, `sequence`=8, `caption`='Имя поля в БД', `field_name`='field_name', `add_parameter`=0, `default_value`='', `not_null`=0, `sql_parameter`='', `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='' WHERE `da_object_parameters`.`id_object`=21 AND `da_object_parameters`.`id_parameter`=80");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`=21, `id_parameter`=78, `id_parameter_type`=2, `sequence`=7, `caption`='Виджет', `field_name`='widget', `add_parameter`=0, `default_value`='', `not_null`=0, `sql_parameter`='', `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='Алиас до виджета. Например ygin.widgets.textField.TextFieldWidget' WHERE `da_object_parameters`.`id_object`=21 AND `da_object_parameters`.`id_parameter`=78");
    $this->execute("UPDATE `da_object_parameters` SET widget=field_name WHERE id_parameter_type=10 AND id_parameter NOT IN (89, 549, 544)");
    $this->execute("UPDATE `da_object_parameters` SET field_name=NULL WHERE id_parameter_type=10");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=2 WHERE `da_object_parameters`.`id_object`=21 AND `da_object_parameters`.`id_parameter`=79");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=3 WHERE `da_object_parameters`.`id_object`=21 AND `da_object_parameters`.`id_parameter`=75");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=4 WHERE `da_object_parameters`.`id_object`=21 AND `da_object_parameters`.`id_parameter`=74");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=5 WHERE `da_object_parameters`.`id_object`=21 AND `da_object_parameters`.`id_parameter`=77");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=6 WHERE `da_object_parameters`.`id_object`=21 AND `da_object_parameters`.`id_parameter`=80");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=8 WHERE `da_object_parameters`.`id_object`=21 AND `da_object_parameters`.`id_parameter`=81");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=9 WHERE `da_object_parameters`.`id_object`=21 AND `da_object_parameters`.`id_parameter`=87");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=10 WHERE `da_object_parameters`.`id_object`=21 AND `da_object_parameters`.`id_parameter`=83");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=11 WHERE `da_object_parameters`.`id_object`=21 AND `da_object_parameters`.`id_parameter`=84");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=12 WHERE `da_object_parameters`.`id_object`=21 AND `da_object_parameters`.`id_parameter`=206");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=13 WHERE `da_object_parameters`.`id_object`=21 AND `da_object_parameters`.`id_parameter`=220");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=14 WHERE `da_object_parameters`.`id_object`=21 AND `da_object_parameters`.`id_parameter`=156");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=15 WHERE `da_object_parameters`.`id_object`=21 AND `da_object_parameters`.`id_parameter`=205");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=16 WHERE `da_object_parameters`.`id_object`=21 AND `da_object_parameters`.`id_parameter`=73");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=17 WHERE `da_object_parameters`.`id_object`=21 AND `da_object_parameters`.`id_parameter`=82");
    $this->execute("UPDATE `da_object_parameters` SET widget=NULL WHERE widget=field_name");
    $this->execute("UPDATE `da_object_parameters` SET widget=NULL WHERE widget IS NOT NULL AND field_name IS NOT NULL AND id_parameter NOT IN (76, 91, 420)");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
