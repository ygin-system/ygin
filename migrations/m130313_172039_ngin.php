<?php

class m130313_172039_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE `da_object` SET `id_object`=513, `name`='OpenID провайдер', `id_field_order`=1590, `order_type`=1, `table_name`='pr_open_id_provider', `id_field_caption`=1590, `object_type`=1, `folder_name`='content/open_id_provider', `parent_object`=2, `sequence`=37, `seq_start_value`=1, `use_domain_isolation`=0, `id_object_handler`=NULL, `id_instance_class`=NULL, `field_caption`='name', `yii_model`=NULL WHERE `da_object`.`id_object`=513");
    $this->execute("DELETE FROM da_search_data WHERE id_object=80 AND id_instance='1031'");
    $this->execute("DELETE FROM `da_php_script_type` WHERE `da_php_script_type`.`id_php_script_type`=1031");
    $this->execute("UPDATE `da_object` SET `id_object`=514, `name`='OpenId аккаунты', `id_field_order`=1593, `order_type`=1, `table_name`='pr_open_id_account', `id_field_caption`=1594, `object_type`=1, `folder_name`='content/open_id_account/', `parent_object`=2, `sequence`=36, `seq_start_value`=1, `use_domain_isolation`=0, `id_object_handler`=NULL, `id_instance_class`=NULL, `field_caption`='account', `yii_model`=NULL WHERE `da_object`.`id_object`=514");
    $this->execute("INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('dev', 'list_object_514')");
    $this->execute("DELETE FROM da_search_data WHERE id_object=80 AND id_instance='1030'");
    $this->execute("DELETE FROM `da_php_script_type` WHERE `da_php_script_type`.`id_php_script_type`=1030");
    $this->execute("DELETE FROM da_search_data WHERE id_object=66 AND id_instance='6045'");
    $this->execute("DELETE FROM `da_object_view_column` WHERE `da_object_view_column`.`id_object_view_column`=6045");
    $this->execute("DELETE FROM da_search_data WHERE id_object=63 AND id_instance='2012'");
    $this->execute("DELETE FROM `da_object_view` WHERE `da_object_view`.`id_object_view`=2012");
    $this->execute("UPDATE `da_object` SET `id_object`=513, `name`='OpenID провайдер', `id_field_order`=NULL, `order_type`=1, `table_name`='pr_open_id_provider', `id_field_caption`=NULL, `object_type`=1, `folder_name`='content/open_id_provider', `parent_object`=2, `sequence`=37, `seq_start_value`=1, `use_domain_isolation`=0, `id_object_handler`=NULL, `id_instance_class`=NULL, `field_caption`='name', `yii_model`=NULL WHERE `da_object`.`id_object`=513");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='1592'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=513 AND `da_object_parameters`.`id_parameter`=1592");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='1591'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=513 AND `da_object_parameters`.`id_parameter`=1591");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='1590'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=513 AND `da_object_parameters`.`id_parameter`=1590");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='1589'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=513 AND `da_object_parameters`.`id_parameter`=1589");
    $this->execute("DELETE FROM da_domain_object WHERE id_object = '513'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=20 AND id_instance='513'");
    $this->execute("DELETE FROM `da_object` WHERE `da_object`.`id_object`=513");
    $this->execute("DELETE FROM da_search_data WHERE id_object=66 AND id_instance='6047'");
    $this->execute("DELETE FROM `da_object_view_column` WHERE `da_object_view_column`.`id_object_view_column`=6047");
    $this->execute("DELETE FROM da_search_data WHERE id_object=66 AND id_instance='6046'");
    $this->execute("DELETE FROM `da_object_view_column` WHERE `da_object_view_column`.`id_object_view_column`=6046");
    $this->execute("DELETE FROM da_search_data WHERE id_object=63 AND id_instance='2013'");
    $this->execute("DELETE FROM `da_object_view` WHERE `da_object_view`.`id_object_view`=2013");
    $this->execute("UPDATE `da_object` SET `id_object`=514, `name`='OpenId аккаунты', `id_field_order`=NULL, `order_type`=1, `table_name`='pr_open_id_account', `id_field_caption`=NULL, `object_type`=1, `folder_name`='content/open_id_account/', `parent_object`=2, `sequence`=36, `seq_start_value`=1, `use_domain_isolation`=0, `id_object_handler`=NULL, `id_instance_class`=NULL, `field_caption`='account', `yii_model`=NULL WHERE `da_object`.`id_object`=514");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='1596'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=514 AND `da_object_parameters`.`id_parameter`=1596");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='1595'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=514 AND `da_object_parameters`.`id_parameter`=1595");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='1594'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=514 AND `da_object_parameters`.`id_parameter`=1594");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='1593'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=514 AND `da_object_parameters`.`id_parameter`=1593");
    $this->execute("DELETE FROM da_domain_object WHERE id_object = '514'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=20 AND id_instance='514'");
    $this->execute("DELETE FROM `da_object` WHERE `da_object`.`id_object`=514");
    $this->execute("DELETE FROM da_domain_object WHERE id_object = '68'");
    $this->execute("DELETE FROM `da_auth_item` WHERE name='list_object_68'");
    $this->execute("DELETE FROM `da_auth_item` WHERE name='view_object_68'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=20 AND id_instance='68'");
    $this->execute("DELETE FROM `da_object` WHERE `da_object`.`id_object`=68");
    $this->execute("DELETE FROM `da_auth_item` WHERE name='list_object_529'");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
