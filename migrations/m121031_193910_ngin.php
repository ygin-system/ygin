<?php

class m121031_193910_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 80 AND id_instance = 422)");
    $this->execute("DELETE FROM da_localization_element WHERE id_object = 80 AND id_instance = 422");
    $this->execute("DELETE FROM da_object_property_value WHERE id_object_instance=422 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=80)");
    $this->execute("DELETE FROM da_php_script_type WHERE id_php_script_type=422");
    $this->execute("UPDATE `da_object` SET `id_object_handler`=NULL WHERE `da_object`.`id_object`=31");
    $this->execute("DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 80 AND id_instance = 418)");
    $this->execute("DELETE FROM da_localization_element WHERE id_object = 80 AND id_instance = 418");
    $this->execute("DELETE FROM da_object_property_value WHERE id_object_instance=418 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=80)");
    $this->execute("DELETE FROM da_php_script_type WHERE id_php_script_type=418");
    $this->execute("DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 80 AND id_instance = 402)");
    $this->execute("DELETE FROM da_localization_element WHERE id_object = 80 AND id_instance = 402");
    $this->execute("DELETE FROM da_object_property_value WHERE id_object_instance=402 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=80)");
    $this->execute("DELETE FROM da_php_script_type WHERE id_php_script_type=402");
    $this->execute("DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 80 AND id_instance = 403)");
    $this->execute("DELETE FROM da_localization_element WHERE id_object = 80 AND id_instance = 403");
    $this->execute("DELETE FROM da_object_property_value WHERE id_object_instance=403 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=80)");
    $this->execute("DELETE FROM da_php_script_type WHERE id_php_script_type=403");
    $this->execute("UPDATE `da_object` SET `id_object_handler`=NULL WHERE `da_object`.`id_object`=37");
    $this->execute("UPDATE `da_object` SET `id_object_handler`=NULL WHERE `da_object`.`id_object`=103");
    $this->execute("DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 80 AND id_instance = 406)");
    $this->execute("DELETE FROM da_localization_element WHERE id_object = 80 AND id_instance = 406");
    $this->execute("DELETE FROM da_object_property_value WHERE id_object_instance=406 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=80)");
    $this->execute("DELETE FROM da_php_script_type WHERE id_php_script_type=406");
    $this->execute("UPDATE `da_object` SET `id_object_handler`=NULL WHERE `da_object`.`id_object`=20");
    $this->execute("UPDATE `da_object` SET `id_object_handler`=NULL WHERE `da_object`.`id_object`=105");
    $this->execute("DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 80 AND id_instance = 409)");
    $this->execute("DELETE FROM da_localization_element WHERE id_object = 80 AND id_instance = 409");
    $this->execute("DELETE FROM da_object_property_value WHERE id_object_instance=409 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=80)");
    $this->execute("DELETE FROM da_php_script_type WHERE id_php_script_type=409");
    $this->execute("DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 80 AND id_instance = 412)");
    $this->execute("DELETE FROM da_localization_element WHERE id_object = 80 AND id_instance = 412");
    $this->execute("DELETE FROM da_object_property_value WHERE id_object_instance=412 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=80)");
    $this->execute("DELETE FROM da_php_script_type WHERE id_php_script_type=412");
    $this->execute("UPDATE `da_object` SET `id_object_handler`=NULL WHERE `da_object`.`id_object`=42");
    $this->execute("DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 21 AND id_instance = 379)");
    $this->execute("DELETE FROM da_localization_element WHERE id_object = 21 AND id_instance = 379");
    $this->execute("DELETE FROM da_object_property_value WHERE id_object_instance=379 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=21)");
    $this->execute("DELETE FROM da_object_parameters WHERE id_parameter=379");
    $this->execute("UPDATE `da_object` SET `id_object_handler`=NULL WHERE `da_object`.`id_object`=90");
    $this->execute("DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 80 AND id_instance = 419)");
    $this->execute("DELETE FROM da_localization_element WHERE id_object = 80 AND id_instance = 419");
    $this->execute("DELETE FROM da_object_property_value WHERE id_object_instance=419 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=80)");
    $this->execute("DELETE FROM da_php_script_type WHERE id_php_script_type=419");
    $this->execute("DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 80 AND id_instance = 1013)");
    $this->execute("DELETE FROM da_localization_element WHERE id_object = 80 AND id_instance = 1013");
    $this->execute("DELETE FROM da_object_property_value WHERE id_object_instance=1013 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=80)");
    $this->execute("DELETE FROM da_php_script_type WHERE id_php_script_type=1013");
    $this->execute("DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 80 AND id_instance = 423)");
    $this->execute("DELETE FROM da_localization_element WHERE id_object = 80 AND id_instance = 423");
    $this->execute("DELETE FROM da_object_property_value WHERE id_object_instance=423 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=80)");
    $this->execute("DELETE FROM da_php_script_type WHERE id_php_script_type=423");
    $this->execute("DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 80 AND id_instance = 424)");
    $this->execute("DELETE FROM da_localization_element WHERE id_object = 80 AND id_instance = 424");
    $this->execute("DELETE FROM da_object_property_value WHERE id_object_instance=424 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=80)");
    $this->execute("DELETE FROM da_php_script_type WHERE id_php_script_type=424");
    $this->execute("DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 80 AND id_instance = 420)");
    $this->execute("DELETE FROM da_localization_element WHERE id_object = 80 AND id_instance = 420");
    $this->execute("DELETE FROM da_object_property_value WHERE id_object_instance=420 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=80)");
    $this->execute("DELETE FROM da_php_script_type WHERE id_php_script_type=420");
    $this->execute("UPDATE da_object_view_column SET id_object_view = '67', id_object = '250', caption = 'Ссылка', visible = '0', order_no = '21', id_object_parameter = NULL, id_data_type = '10', field_name = '-', handler = '443' WHERE id_object_view_column=148");
    $this->execute("UPDATE `da_object` SET `id_object_handler`=NULL, `id_instance_class`=NULL, `yii_model`='photogallery.models.PhotogalleryPhoto' WHERE `da_object`.`id_object`=501");
    $this->execute("UPDATE `da_object` SET `id_object_handler`=NULL, `id_instance_class`=459, `yii_model`=NULL WHERE `da_object`.`id_object`=261");
    $this->execute("UPDATE `da_object` SET `id_object_handler`=NULL, `id_instance_class`=460, `yii_model`=NULL WHERE `da_object`.`id_object`=260");
    $this->execute("UPDATE `da_object` SET `id_object_handler`=NULL, `id_instance_class`=458, `yii_model`='comments.models.CommentYii' WHERE `da_object`.`id_object`=250");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false, false, false);
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
