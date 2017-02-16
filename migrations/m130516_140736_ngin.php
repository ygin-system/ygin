<?php

class m130516_140736_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE `da_object` SET `id_object`=45, `name`='AJAX', `id_field_order`=NULL, `order_type`=1, `table_name`='da_ajax', `id_field_caption`=NULL, `object_type`=1, `folder_name`='', `parent_object`=1, `sequence`=18, `seq_start_value`=1000, `use_domain_isolation`=0, `id_object_handler`=NULL, `id_instance_class`=NULL, `field_caption`='function_name', `yii_model`='' WHERE `da_object`.`id_object`=45");
    $this->execute("UPDATE `da_object` SET `id_object`=66, `name`='Колонка представления', `id_field_order`=419, `order_type`=1, `table_name`='da_object_view_column', `id_field_caption`=NULL, `object_type`=1, `folder_name`='', `parent_object`=63, `sequence`=9, `seq_start_value`=6000, `use_domain_isolation`=0, `id_object_handler`=NULL, `id_instance_class`=NULL, `field_caption`=NULL, `yii_model`='yiigin.models.DaObjectViewColumn' WHERE `da_object`.`id_object`=66");
    $this->execute("DELETE FROM `da_object_view_column` WHERE `da_object_view_column`.`id_object_view_column`=51");
    $this->execute("DELETE FROM `da_object_view_column` WHERE `da_object_view_column`.`id_object_view_column`=52");
    $this->execute("DELETE FROM `da_object_view_column` WHERE `da_object_view_column`.`id_object_view_column`=53");
    $this->execute("UPDATE `da_object` SET `id_object`=63, `name`='Представление', `id_field_order`=408, `order_type`=1, `table_name`='da_object_view', `id_field_caption`=406, `object_type`=1, `folder_name`='', `parent_object`=1, `sequence`=8, `seq_start_value`=2000, `use_domain_isolation`=0, `id_object_handler`=NULL, `id_instance_class`=NULL, `field_caption`='name', `yii_model`='yiigin.models.DaObjectView' WHERE `da_object`.`id_object`=63");
    $this->execute("DELETE FROM `da_object_view` WHERE `da_object_view`.`id_object_view`=27");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=45 AND `da_object_parameters`.`id_parameter`=228");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=45 AND `da_object_parameters`.`id_parameter`=227");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=45 AND `da_object_parameters`.`id_parameter`=226");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=45 AND `da_object_parameters`.`id_parameter`=225");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=45 AND `da_object_parameters`.`id_parameter`=224");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=45 AND `da_object_parameters`.`id_parameter`=223");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=45 AND `da_object_parameters`.`id_parameter`=222");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=45 AND `da_object_parameters`.`id_parameter`=233");
    $this->execute("DELETE FROM da_domain_object WHERE id_object = '45'");
    $this->execute("DELETE FROM `da_auth_item` WHERE name='create_object_45'");
    $this->execute("DELETE FROM `da_auth_item` WHERE name='delete_object_45'");
    $this->execute("DELETE FROM `da_auth_item` WHERE name='edit_object_45'");
    $this->execute("DELETE FROM `da_auth_item` WHERE name='list_object_45'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=20 AND id_instance='45'");
    $this->execute("DELETE FROM `da_object` WHERE `da_object`.`id_object`=45");
    $this->execute("UPDATE `da_object` SET `id_object`=57, `name`='Interface localization', `id_field_order`=321, `order_type`=1, `table_name`='da_localization_interface', `id_field_caption`=320, `object_type`=1, `folder_name`='', `parent_object`=10, `sequence`=3, `seq_start_value`=500, `use_domain_isolation`=0, `id_object_handler`=NULL, `id_instance_class`=NULL, `field_caption`='name', `yii_model`='' WHERE `da_object`.`id_object`=57");
    $this->execute("DELETE FROM `da_auth_item_child` WHERE parent='dev' AND child='edit_object_57'");
    $this->execute("DELETE FROM `da_auth_item_child` WHERE parent='dev' AND child='delete_object_57'");
    $this->execute("DELETE FROM `da_auth_item_child` WHERE parent='dev' AND child='create_object_57'");
    $this->execute("DELETE FROM `da_auth_item_child` WHERE parent='dev' AND child='list_object_57'");
    $this->execute("UPDATE `da_object` SET `id_object`=55, `name`='Локализация данных', `id_field_order`=314, `order_type`=1, `table_name`='da_localization_element', `id_field_caption`=317, `object_type`=1, `folder_name`='', `parent_object`=10, `sequence`=2, `seq_start_value`=10000, `use_domain_isolation`=0, `id_object_handler`=NULL, `id_instance_class`=NULL, `field_caption`='id_instance', `yii_model`='' WHERE `da_object`.`id_object`=55");
    $this->execute("DELETE FROM `da_auth_item_child` WHERE parent='dev' AND child='edit_object_55'");
    $this->execute("DELETE FROM `da_auth_item_child` WHERE parent='dev' AND child='delete_object_55'");
    $this->execute("DELETE FROM `da_auth_item_child` WHERE parent='dev' AND child='list_object_55'");
    $this->execute("UPDATE `da_object` SET `id_object`=54, `name`='Доступные локализации', `id_field_order`=310, `order_type`=1, `table_name`='da_localization', `id_field_caption`=311, `object_type`=1, `folder_name`='', `parent_object`=10, `sequence`=1, `seq_start_value`=1, `use_domain_isolation`=0, `id_object_handler`=NULL, `id_instance_class`=NULL, `field_caption`='name', `yii_model`='' WHERE `da_object`.`id_object`=54");
    $this->execute("DELETE FROM `da_auth_item_child` WHERE parent='dev' AND child='edit_object_54'");
    $this->execute("DELETE FROM `da_auth_item_child` WHERE parent='dev' AND child='delete_object_54'");
    $this->execute("DELETE FROM `da_auth_item_child` WHERE parent='dev' AND child='create_object_54'");
    $this->execute("DELETE FROM `da_auth_item_child` WHERE parent='dev' AND child='list_object_54'");
    $this->execute("UPDATE `da_object` SET `id_object`=42, `name`='RSS', `id_field_order`=602, `order_type`=1, `table_name`='da_rss', `id_field_caption`=NULL, `object_type`=1, `folder_name`='', `parent_object`=5, `sequence`=10, `seq_start_value`=1, `use_domain_isolation`=0, `id_object_handler`=NULL, `id_instance_class`=NULL, `field_caption`=NULL, `yii_model`='' WHERE `da_object`.`id_object`=42");
    $this->execute("DELETE FROM `da_auth_item_child` WHERE parent='dev' AND child='edit_object_42'");
    $this->execute("DELETE FROM `da_auth_item_child` WHERE parent='dev' AND child='create_object_42'");
    $this->execute("DELETE FROM `da_auth_item_child` WHERE parent='dev' AND child='list_object_42'");
    $this->execute("DELETE FROM da_domain_object WHERE id_object = '92'");
    $this->execute("DELETE FROM `da_auth_item` WHERE name='list_object_92'");
    $this->execute("DELETE FROM `da_auth_item` WHERE name='view_object_92'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=20 AND id_instance='92'");
    $this->execute("DELETE FROM `da_object` WHERE `da_object`.`id_object`=92");
    $this->execute("DELETE FROM `da_object_view_column` WHERE `da_object_view_column`.`id_object_view_column`=175");
    $this->execute("DELETE FROM `da_object_view_column` WHERE `da_object_view_column`.`id_object_view_column`=174");
    $this->execute("DELETE FROM `da_object_view` WHERE `da_object_view`.`id_object_view`=73");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=93 AND `da_object_parameters`.`id_parameter`=1247");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=93 AND `da_object_parameters`.`id_parameter`=1246");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=93 AND `da_object_parameters`.`id_parameter`=1245");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=93 AND `da_object_parameters`.`id_parameter`=1244");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=93 AND `da_object_parameters`.`id_parameter`=1243");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=93 AND `da_object_parameters`.`id_parameter`=1242");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=93 AND `da_object_parameters`.`id_parameter`=1241");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=93 AND `da_object_parameters`.`id_parameter`=1240");
    $this->execute("DELETE FROM da_domain_object WHERE id_object = '93'");
    $this->execute("DELETE FROM `da_object` WHERE `da_object`.`id_object`=93");
    $this->execute("DELETE FROM `da_object_view_column` WHERE `da_object_view_column`.`id_object_view_column`=56");
    $this->execute("DELETE FROM `da_object_view_column` WHERE `da_object_view_column`.`id_object_view_column`=57");
    $this->execute("DELETE FROM `da_object_view_column` WHERE `da_object_view_column`.`id_object_view_column`=58");
    $this->execute("DELETE FROM `da_object_view_column` WHERE `da_object_view_column`.`id_object_view_column`=59");
    $this->execute("DELETE FROM `da_object_view` WHERE `da_object_view`.`id_object_view`=30");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=48 AND `da_object_parameters`.`id_parameter`=244");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=48 AND `da_object_parameters`.`id_parameter`=243");
    $this->execute("UPDATE `da_object` SET `id_object`=48, `name`='Флаги', `id_field_order`=NULL, `order_type`=1, `table_name`='da_rules_process_text', `id_field_caption`=NULL, `object_type`=1, `folder_name`='', `parent_object`=1, `sequence`=21, `seq_start_value`=1, `use_domain_isolation`=0, `id_object_handler`=NULL, `id_instance_class`=NULL, `field_caption`=NULL, `yii_model`='' WHERE `da_object`.`id_object`=48");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=48 AND `da_object_parameters`.`id_parameter`=242");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=48 AND `da_object_parameters`.`id_parameter`=241");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=48 AND `da_object_parameters`.`id_parameter`=240");
    $this->execute("DELETE FROM da_domain_object WHERE id_object = '48'");
    $this->execute("DELETE FROM `da_object` WHERE `da_object`.`id_object`=48");
    $this->execute("DELETE FROM da_domain_object WHERE id_object = '65'");
    $this->execute("DELETE FROM `da_object` WHERE `da_object`.`id_object`=65");
    $this->execute("DELETE FROM da_domain_object WHERE id_object = '64'");
    $this->execute("DELETE FROM `da_object` WHERE `da_object`.`id_object`=64");
    $this->execute("DELETE FROM `da_php_script_type` WHERE `da_php_script_type`.`id_php_script_type`=20");
    $this->execute("DELETE FROM `da_php_script_interface` WHERE `da_php_script_interface`.`id_php_script_interface`=4");
    $this->execute("UPDATE `da_object_view_column` SET `id_object_view_column`=114, `id_object_view`=53, `id_object`=90, `caption`='Связь', `order_no`=2, `id_object_parameter`=NULL, `id_data_type`=10, `field_name`='-', `handler`=NULL, `visible`=1 WHERE `da_object_view_column`.`id_object_view_column`=114");
    $this->execute("DELETE FROM `da_object_view_column` WHERE `da_object_view_column`.`id_object_view_column`=114");
    $this->execute("DELETE FROM `da_object_view_column` WHERE `da_object_view_column`.`id_object_view_column`=113");
    $this->execute("DELETE FROM `da_php_script_type` WHERE `da_php_script_type`.`id_php_script_type`=2");
    $this->execute("DELETE FROM `da_object_view` WHERE `da_object_view`.`id_object_view`=53");
    $this->execute("UPDATE `da_object` SET `id_object`=90, `name`='Системные модули', `id_field_order`=NULL, `order_type`=1, `table_name`='da_module', `id_field_caption`=NULL, `object_type`=1, `folder_name`='', `parent_object`=1, `sequence`=7, `seq_start_value`=1000, `use_domain_isolation`=0, `id_object_handler`=NULL, `id_instance_class`=446, `field_caption`='name', `yii_model`='yiigin.models.DaSystemModule' WHERE `da_object`.`id_object`=90");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=90 AND `da_object_parameters`.`id_parameter`=378");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=90 AND `da_object_parameters`.`id_parameter`=376");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=90 AND `da_object_parameters`.`id_parameter`=377");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=90 AND `da_object_parameters`.`id_parameter`=375");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=90 AND `da_object_parameters`.`id_parameter`=371");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=90 AND `da_object_parameters`.`id_parameter`=372");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=90 AND `da_object_parameters`.`id_parameter`=370");
    $this->execute("DELETE FROM da_domain_object WHERE id_object = '90'");
    $this->execute("DELETE FROM `da_auth_item` WHERE name='create_object_90'");
    $this->execute("DELETE FROM `da_auth_item` WHERE name='delete_object_90'");
    $this->execute("DELETE FROM `da_auth_item` WHERE name='edit_object_90'");
    $this->execute("DELETE FROM `da_auth_item` WHERE name='list_object_90'");
    $this->execute("DELETE FROM `da_object` WHERE `da_object`.`id_object`=90");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
