<?php

class m120807_131907_ngin extends CDbMigration {
  public function up() {
    $this->execute("

DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 63 AND id_instance = 34);
DELETE FROM da_localization_element WHERE id_object = 63 AND id_instance = 34;
DELETE FROM da_object_property_value WHERE id_object_instance=34 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=63);
DELETE FROM da_object_view WHERE id_object_view=34;

DELETE FROM da_domain_object WHERE id_object = 53;
DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 20 AND id_instance = 53);
DELETE FROM da_localization_element WHERE id_object = 20 AND id_instance = 53;
DELETE FROM da_object_property_value WHERE id_object_instance=53 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=20);
DELETE FROM da_object WHERE id_object=53;

UPDATE da_object SET sequence = '1', name = 'Инструкция', object_type = '3', table_name = 'engine/admin/special/instr.php', folder_name = NULL, id_field_caption = NULL, id_field_order = NULL, order_type = '1', seq_start_value = '1', id_object_handler = NULL, id_instance_class = NULL, parent_object = '7', use_domain_isolation = '0' WHERE id_object=62;
DELETE FROM da_domain_object WHERE id_object = 62;
INSERT INTO da_domain_object(id_domain, id_object) 
                               VALUES(1, 62);
DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 26 AND id_instance = 111);
DELETE FROM da_localization_element WHERE id_object = 26 AND id_instance = 111;
DELETE FROM da_object_property_value WHERE id_object_instance=111 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=26);
DELETE FROM da_permissions WHERE id_permission=111;
DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 26 AND id_instance = 147);
DELETE FROM da_localization_element WHERE id_object = 26 AND id_instance = 147;
DELETE FROM da_object_property_value WHERE id_object_instance=147 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=26);
DELETE FROM da_permissions WHERE id_permission=147;

DELETE FROM da_domain_object WHERE id_object = 62;
DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 20 AND id_instance = 62);
DELETE FROM da_localization_element WHERE id_object = 20 AND id_instance = 62;
DELETE FROM da_object_property_value WHERE id_object_instance=62 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=20);
DELETE FROM da_object WHERE id_object=62;

DELETE FROM da_domain_object WHERE id_object = 7;
DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 20 AND id_instance = 7);
DELETE FROM da_localization_element WHERE id_object = 20 AND id_instance = 7;
DELETE FROM da_object_property_value WHERE id_object_instance=7 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=20);
DELETE FROM da_object WHERE id_object=7;

DELETE FROM da_domain_object WHERE id_object = 11;
DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 20 AND id_instance = 11);
DELETE FROM da_localization_element WHERE id_object = 20 AND id_instance = 11;
DELETE FROM da_object_property_value WHERE id_object_instance=11 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=20);
DELETE FROM da_object WHERE id_object=11;


");
  }
  
  public function down() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }

  /*
  public function safeUp() {
  }
  public function safeDown() {
  }
  */
}
