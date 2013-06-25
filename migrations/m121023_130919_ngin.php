<?php

class m121023_130919_ngin extends CDbMigration {
  public function safeUp() {
   
    $this->execute("UPDATE `da_object` SET `yii_model`='ngin.models.object.ObjectParameter' WHERE `id_object`=21");
    $this->execute("UPDATE `da_object` SET `yii_model`='yiigin.models.DaSystemModule' WHERE `da_object`.`id_object`=90");
    $this->execute("UPDATE `da_object` SET `yii_model`='user.models.User' WHERE `da_object`.`id_object`=24");
    $this->execute("UPDATE `da_object` SET `yii_model`='ngin.models.File' WHERE `da_object`.`id_object`=37");
    $this->execute("UPDATE `da_object` SET `yii_model`='ngin.models.Domain' WHERE `da_object`.`id_object`=31");
    $this->execute("UPDATE `da_object` SET `id_object_handler`=NULL, `id_instance_class`=NULL, `yii_model`=NULL WHERE `da_object`.`id_object`=61");
    $this->execute("UPDATE `da_object` SET `id_object`=95, `name`='Тема сайта', `id_field_order`=NULL, `order_type`=1, `table_name`='da_site_theme', `id_field_caption`=NULL, `object_type`=1, `folder_name`=NULL, `parent_object`=3, `sequence`=38, `seq_start_value`=1, `use_domain_isolation`=0, `id_object_handler`=NULL, `id_instance_class`=NULL, `field_caption`='name', `yii_model`=NULL WHERE `da_object`.`id_object`=95");
    $this->execute("UPDATE `da_object` SET `id_object_handler`=1013, `id_instance_class`=NULL, `yii_model`='photogallery.models.PhotogalleryPhoto' WHERE `da_object`.`id_object`=501");
    $this->execute("DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 80 AND id_instance = 452)");
    $this->execute("DELETE FROM da_localization_element WHERE id_object = 80 AND id_instance = 452");
    $this->execute("DELETE FROM da_object_property_value WHERE id_object_instance=452 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=80)");
    $this->execute("DELETE FROM da_php_script_type WHERE id_php_script_type=452");
    $this->execute("DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 66 AND id_instance = 176)");
    $this->execute("DELETE FROM da_localization_element WHERE id_object = 66 AND id_instance = 176");
    $this->execute("DELETE FROM da_object_property_value WHERE id_object_instance=176 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=66)");
    $this->execute("DELETE FROM da_object_view_column WHERE id_object_view_column=176");
    $this->execute("DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 63 AND id_instance = 76)");
    $this->execute("DELETE FROM da_localization_element WHERE id_object = 63 AND id_instance = 76");
    $this->execute("DELETE FROM da_object_property_value WHERE id_object_instance=76 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=63)");
    $this->execute("DELETE FROM da_object_view WHERE id_object_view=76");
    $this->execute("DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 21 AND id_instance = 333)");
    $this->execute("DELETE FROM da_localization_element WHERE id_object = 21 AND id_instance = 333");
    $this->execute("DELETE FROM da_object_property_value WHERE id_object_instance=333 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=21)");
    $this->execute("DELETE FROM da_object_parameters WHERE id_parameter=333");
    $this->execute("DELETE FROM da_domain_object WHERE id_object = 95");
    $this->execute("DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 21 AND id_instance = 331)");
    $this->execute("DELETE FROM da_localization_element WHERE id_object = 21 AND id_instance = 331");
    $this->execute("DELETE FROM da_object_property_value WHERE id_object_instance=331 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=21)");
    $this->execute("DELETE FROM da_object_parameters WHERE id_parameter=331");
    $this->execute("DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 21 AND id_instance = 332)");
    $this->execute("DELETE FROM da_localization_element WHERE id_object = 21 AND id_instance = 332");
    $this->execute("DELETE FROM da_object_property_value WHERE id_object_instance=332 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=21)");
    $this->execute("DELETE FROM da_object_parameters WHERE id_parameter=332");
    $this->execute("DELETE FROM da_domain_object WHERE id_object = 95");
    $this->execute("DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 20 AND id_instance = 95)");
    $this->execute("DELETE FROM da_localization_element WHERE id_object = 20 AND id_instance = 95");
    $this->execute("DELETE FROM da_object_property_value WHERE id_object_instance=95 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=20)");
    $this->execute("DELETE FROM da_object WHERE id_object=95");
    $this->execute("DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 80 AND id_instance = 461)");
    $this->execute("DELETE FROM da_localization_element WHERE id_object = 80 AND id_instance = 461");
    $this->execute("DELETE FROM da_object_property_value WHERE id_object_instance=461 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=80)");
    $this->execute("DELETE FROM da_php_script_type WHERE id_php_script_type=461");
    $this->execute("DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 80 AND id_instance = 1017)");
    $this->execute("DELETE FROM da_localization_element WHERE id_object = 80 AND id_instance = 1017");
    $this->execute("DELETE FROM da_object_property_value WHERE id_object_instance=1017 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=80)");
    $this->execute("DELETE FROM da_php_script_type WHERE id_php_script_type=1017");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false);
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
