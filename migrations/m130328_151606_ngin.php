<?php

class m130328_151606_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("INSERT INTO `da_object_parameters` (id_parameter, `id_parameter_type`, `caption`, `id_object`, `sequence`, `name`, `field_name`, `add_parameter`, `sql_parameter`, `default_value`, `not_null`, `need_locale`, `search`, `group_type`, `is_additional`, `hint`, `is_unique`) VALUES (334, 9, 'Активен', 80, 0, 'active', 'active', NULL, NULL, '1', 1, 0, 0, 0, 0, NULL, 0)");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=3 WHERE `da_object_parameters`.`id_object`=80 AND `da_object_parameters`.`id_parameter`=339");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=4 WHERE `da_object_parameters`.`id_object`=80 AND `da_object_parameters`.`id_parameter`=340");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=5 WHERE `da_object_parameters`.`id_object`=80 AND `da_object_parameters`.`id_parameter`=342");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=6 WHERE `da_object_parameters`.`id_object`=80 AND `da_object_parameters`.`id_parameter`=334");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=3 WHERE `da_object_parameters`.`id_object`=80 AND `da_object_parameters`.`id_parameter`=342");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=4 WHERE `da_object_parameters`.`id_object`=80 AND `da_object_parameters`.`id_parameter`=339");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=5 WHERE `da_object_parameters`.`id_object`=80 AND `da_object_parameters`.`id_parameter`=340");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=4 WHERE `da_object_parameters`.`id_object`=80 AND `da_object_parameters`.`id_parameter`=334");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=5 WHERE `da_object_parameters`.`id_object`=80 AND `da_object_parameters`.`id_parameter`=339");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=6 WHERE `da_object_parameters`.`id_object`=80 AND `da_object_parameters`.`id_parameter`=340");
    $this->execute("INSERT INTO `da_object_view_column` (id_object_view_column, `id_object_view`, `id_object`, `caption`, `visible`, `order_no`, `id_object_parameter`, `id_data_type`, `field_name`, `handler`) VALUES (105, 50, 80, 'Доступен', 1, 0, 334, 9, 'active', NULL)");
    $this->execute("UPDATE `da_php_script_type` SET `active`=0 WHERE `id_php_script_type` NOT IN (SELECT id_php_script_type FROM da_module_view a JOIN da_domain_module b ON a.id_module=b.id_module) AND `id_php_script_interface`=2");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='288'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=31 AND `da_object_parameters`.`id_parameter`=288");
    $this->execute("UPDATE `da_object` SET `id_object`=90, `name`='Системные модули', `id_field_order`=372, `order_type`=1, `table_name`='da_module', `id_field_caption`=372, `object_type`=1, `folder_name`=NULL, `parent_object`=1, `sequence`=7, `seq_start_value`=1000, `use_domain_isolation`=0, `id_object_handler`=NULL, `id_instance_class`=446, `field_caption`='name', `yii_model`='yiigin.models.DaSystemModule' WHERE `da_object`.`id_object`=90");
    $this->execute("DELETE FROM `da_auth_item_child` WHERE parent='dev' AND child='edit_object_90'");
    $this->execute("DELETE FROM `da_auth_item_child` WHERE parent='dev' AND child='delete_object_90'");
    $this->execute("DELETE FROM `da_auth_item_child` WHERE parent='dev' AND child='create_object_90'");
    $this->execute("DELETE FROM `da_auth_item_child` WHERE parent='dev' AND child='list_object_90'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=80 AND `da_object_parameters`.`id_parameter`=335");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=80 AND `da_object_parameters`.`id_parameter`=336");
    $this->execute("INSERT INTO `da_object_parameters` (id_parameter, `id_parameter_type`, `caption`, `id_object`, `sequence`, `name`, `field_name`, `add_parameter`, `sql_parameter`, `default_value`, `not_null`, `need_locale`, `search`, `group_type`, `is_additional`, `hint`, `is_unique`) VALUES (544, 10, 'Обработчик', 103, 0, 'menu.yiigin.widgets.phpScript.PhpScriptWidget', '-', 2, NULL, NULL, 1, 0, 0, 0, 0, NULL, 0)");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=4 WHERE `da_object_parameters`.`id_object`=103 AND `da_object_parameters`.`id_parameter`=544");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=5 WHERE `da_object_parameters`.`id_object`=103 AND `da_object_parameters`.`id_parameter`=543");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=6 WHERE `da_object_parameters`.`id_object`=103 AND `da_object_parameters`.`id_parameter`=545");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=7 WHERE `da_object_parameters`.`id_object`=103 AND `da_object_parameters`.`id_parameter`=556");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=8 WHERE `da_object_parameters`.`id_object`=103 AND `da_object_parameters`.`id_parameter`=554");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=9 WHERE `da_object_parameters`.`id_object`=103 AND `da_object_parameters`.`id_parameter`=598");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`=103, `id_parameter`=544, `id_parameter_type`=10, `sequence`=4, `name`='menu.yiigin.widgets.phpScript.PhpScriptWidget', `caption`='Обработчик', `field_name`='link', `add_parameter`=2, `default_value`=NULL, `not_null`=1, `sql_parameter`=NULL, `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`=NULL WHERE `da_object_parameters`.`id_object`=103 AND `da_object_parameters`.`id_parameter`=544");
    $this->execute("UPDATE `da_object_view_column` SET `id_object_view_column`=121, `id_object_view`=57, `id_object`=103, `caption`=NULL, `order_no`=2, `id_object_parameter`=544, `id_data_type`=10, `field_name`='link', `handler`=4, `visible`=1 WHERE `da_object_view_column`.`id_object_view_column`=121");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=103 AND `da_object_parameters`.`id_parameter`=543");
    $this->execute("UPDATE `da_object` SET `id_object`=100, `name`='Меню', `id_field_order`=7, `order_type`=1, `table_name`='da_menu', `id_field_caption`=2, `object_type`=1, `folder_name`='content/menu', `parent_object`=4, `sequence`=1, `seq_start_value`=101, `use_domain_isolation`=0, `id_object_handler`=NULL, `id_instance_class`=449, `field_caption`='name', `yii_model`='Menu' WHERE `da_object`.`id_object`=100");
    $this->execute("DELETE FROM `da_php_script_type` WHERE `da_php_script_type`.`id_php_script_type`=401");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
