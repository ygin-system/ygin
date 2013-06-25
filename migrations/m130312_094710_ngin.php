<?php

class m130312_094710_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object=23)");
    $this->execute("DELETE FROM da_localization_element WHERE id_object=23");
    $this->execute("DELETE FROM da_search_data WHERE id_object=66 AND id_instance='16'");
    $this->execute("DELETE FROM `da_object_view_column` WHERE `da_object_view_column`.`id_object_view_column`=16");
    $this->execute("DELETE FROM da_search_data WHERE id_object=66 AND id_instance='17'");
    $this->execute("DELETE FROM `da_object_view_column` WHERE `da_object_view_column`.`id_object_view_column`=17");
    $this->execute("DELETE FROM da_search_data WHERE id_object=66 AND id_instance='18'");
    $this->execute("DELETE FROM `da_object_view_column` WHERE `da_object_view_column`.`id_object_view_column`=18");
    $this->execute("DELETE FROM da_search_data WHERE id_object=66 AND id_instance='19'");
    $this->execute("DELETE FROM `da_object_view_column` WHERE `da_object_view_column`.`id_object_view_column`=19");
    $this->execute("DELETE FROM da_search_data WHERE id_object=63 AND id_instance='8'");
    $this->execute("DELETE FROM `da_object_view` WHERE `da_object_view`.`id_object_view`=8");
    $this->execute("UPDATE `da_object` SET `id_object`=26, `name`='Права доступа', `id_field_order`=NULL, `order_type`=1, `table_name`='da_permissions', `id_field_caption`=NULL, `object_type`=1, `folder_name`=NULL, `parent_object`=2, `sequence`=3, `seq_start_value`=1000, `use_domain_isolation`=0, `id_object_handler`=NULL, `id_instance_class`=NULL, `field_caption`='id_permission', `yii_model`=NULL WHERE `da_object`.`id_object`=26");
    $this->execute("DELETE FROM da_search_data WHERE id_object=80 AND id_instance='405'");
    $this->execute("DELETE FROM `da_php_script_type` WHERE `da_php_script_type`.`id_php_script_type`=405");
    $this->execute("DELETE FROM da_search_data WHERE id_object=80 AND id_instance='451'");
    $this->execute("DELETE FROM `da_php_script_type` WHERE `da_php_script_type`.`id_php_script_type`=451");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='98'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=26 AND `da_object_parameters`.`id_parameter`=98");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='99'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=26 AND `da_object_parameters`.`id_parameter`=99");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='100'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=26 AND `da_object_parameters`.`id_parameter`=100");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='101'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=26 AND `da_object_parameters`.`id_parameter`=101");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='102'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=26 AND `da_object_parameters`.`id_parameter`=102");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='103'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=26 AND `da_object_parameters`.`id_parameter`=103");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='121'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=26 AND `da_object_parameters`.`id_parameter`=121");
    $this->execute("DELETE FROM da_domain_object WHERE id_object = '26'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=20 AND id_instance='26'");
    $this->execute("DELETE FROM `da_object` WHERE `da_object`.`id_object`=26");
    $this->execute("DELETE FROM da_domain_object WHERE id_object = '32'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=20 AND id_instance='32'");
    $this->execute("DELETE FROM `da_object` WHERE `da_object`.`id_object`=32");
    $this->execute("DELETE FROM da_search_data WHERE id_object=66 AND id_instance='55'");
    $this->execute("DELETE FROM `da_object_view_column` WHERE `da_object_view_column`.`id_object_view_column`=55");
    $this->execute("DELETE FROM da_search_data WHERE id_object=66 AND id_instance='54'");
    $this->execute("DELETE FROM `da_object_view_column` WHERE `da_object_view_column`.`id_object_view_column`=54");
    $this->execute("DELETE FROM da_search_data WHERE id_object=63 AND id_instance='29'");
    $this->execute("DELETE FROM `da_object_view` WHERE `da_object_view`.`id_object_view`=29");
    $this->execute("UPDATE `da_object` SET `id_object`=47, `name`='Права пользователей', `id_field_order`=NULL, `order_type`=1, `table_name`='da_user_permissions', `id_field_caption`=NULL, `object_type`=1, `folder_name`=NULL, `parent_object`=2, `sequence`=2, `seq_start_value`=1, `use_domain_isolation`=0, `id_object_handler`=NULL, `id_instance_class`=NULL, `field_caption`=NULL, `yii_model`=NULL WHERE `da_object`.`id_object`=47");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='234'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=47 AND `da_object_parameters`.`id_parameter`=234");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='235'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=47 AND `da_object_parameters`.`id_parameter`=235");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='236'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=47 AND `da_object_parameters`.`id_parameter`=236");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='237'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=47 AND `da_object_parameters`.`id_parameter`=237");
    $this->execute("DELETE FROM da_domain_object WHERE id_object = '47'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=20 AND id_instance='47'");
    $this->execute("DELETE FROM `da_object` WHERE `da_object`.`id_object`=47");
    $this->execute("DELETE FROM da_search_data WHERE id_object=66 AND id_instance='10'");
    $this->execute("DELETE FROM `da_object_view_column` WHERE `da_object_view_column`.`id_object_view_column`=10");
    $this->execute("DELETE FROM da_search_data WHERE id_object=63 AND id_instance='5'");
    $this->execute("DELETE FROM `da_object_view` WHERE `da_object_view`.`id_object_view`=5");
    $this->execute("UPDATE `da_object` SET `id_object`=23, `name`='Группы пользователей', `id_field_order`=NULL, `order_type`=1, `table_name`='da_groups', `id_field_caption`=NULL, `object_type`=1, `folder_name`=NULL, `parent_object`=2, `sequence`=3, `seq_start_value`=100, `use_domain_isolation`=0, `id_object_handler`=NULL, `id_instance_class`=NULL, `field_caption`='name', `yii_model`=NULL WHERE `da_object`.`id_object`=23");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='95'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=23 AND `da_object_parameters`.`id_parameter`=95");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='94'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=23 AND `da_object_parameters`.`id_parameter`=94");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='72'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`=23 AND `da_object_parameters`.`id_parameter`=72");
    $this->execute("DELETE FROM da_domain_object WHERE id_object = '23'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=20 AND id_instance='23'");
    $this->execute("DELETE FROM `da_object` WHERE `da_object`.`id_object`=23");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
