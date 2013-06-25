<?php

class m120804_002349_ngin extends CDbMigration {
  public function up() {
    $this->execute("

DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 63 AND id_instance = 14);
DELETE FROM da_localization_element WHERE id_object = 63 AND id_instance = 14;
DELETE FROM da_object_property_value WHERE id_object_instance=14 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=63);
DELETE FROM da_object_view WHERE id_object_view=14;

DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 63 AND id_instance = 20);
DELETE FROM da_localization_element WHERE id_object = 63 AND id_instance = 20;
DELETE FROM da_object_property_value WHERE id_object_instance=20 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=63);
DELETE FROM da_object_view WHERE id_object_view=20;

UPDATE da_object SET sequence = '0', name = 'Главная', object_type = '3', table_name = 'engine/admin/about.php', folder_name = NULL, id_field_caption = NULL, id_field_order = NULL, order_type = '1', seq_start_value = '1', id_object_handler = NULL, id_instance_class = NULL, parent_object = '7', use_domain_isolation = '0' WHERE id_object=38;
DELETE FROM da_domain_object WHERE id_object = 38;

DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 26 AND id_instance = 6);
DELETE FROM da_localization_element WHERE id_object = 26 AND id_instance = 6;
DELETE FROM da_object_property_value WHERE id_object_instance=6 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=26);
DELETE FROM da_permissions WHERE id_permission=6;
DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 26 AND id_instance = 5);
DELETE FROM da_localization_element WHERE id_object = 26 AND id_instance = 5;
DELETE FROM da_object_property_value WHERE id_object_instance=5 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=26);
DELETE FROM da_permissions WHERE id_permission=5;
DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 26 AND id_instance = 4);
DELETE FROM da_localization_element WHERE id_object = 26 AND id_instance = 4;
DELETE FROM da_object_property_value WHERE id_object_instance=4 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=26);
DELETE FROM da_permissions WHERE id_permission=4;
DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 26 AND id_instance = 1);
DELETE FROM da_localization_element WHERE id_object = 26 AND id_instance = 1;
DELETE FROM da_object_property_value WHERE id_object_instance=1 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=26);
DELETE FROM da_permissions WHERE id_permission=1;
DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 26 AND id_instance = 135);
DELETE FROM da_localization_element WHERE id_object = 26 AND id_instance = 135;
DELETE FROM da_object_property_value WHERE id_object_instance=135 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=26);
DELETE FROM da_permissions WHERE id_permission=135;

DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 20 AND id_instance = 38);
DELETE FROM da_localization_element WHERE id_object = 20 AND id_instance = 38;
DELETE FROM da_object_property_value WHERE id_object_instance=38 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=20);
DELETE FROM da_object WHERE id_object=38;


UPDATE da_object SET sequence = '0', name = 'на сайт', object_type = '3', table_name = 'объект-заглушка, чтобы раздать права и взять название', folder_name = NULL, id_field_caption = NULL, id_field_order = NULL, order_type = '1', seq_start_value = '1', id_object_handler = NULL, id_instance_class = NULL, parent_object = '7', use_domain_isolation = '0' WHERE id_object=69;
DELETE FROM da_domain_object WHERE id_object = 69;
INSERT INTO da_domain_object(id_domain, id_object) 
                               VALUES(1, 69);
DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 26 AND id_instance = 146);
DELETE FROM da_localization_element WHERE id_object = 26 AND id_instance = 146;
DELETE FROM da_object_property_value WHERE id_object_instance=146 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=26);
DELETE FROM da_permissions WHERE id_permission=146;
DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 26 AND id_instance = 148);
DELETE FROM da_localization_element WHERE id_object = 26 AND id_instance = 148;
DELETE FROM da_object_property_value WHERE id_object_instance=148 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=26);
DELETE FROM da_permissions WHERE id_permission=148;

DELETE FROM da_domain_object WHERE id_object = 69;
DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 20 AND id_instance = 69);
DELETE FROM da_localization_element WHERE id_object = 20 AND id_instance = 69;
DELETE FROM da_object_property_value WHERE id_object_instance=69 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=20);
DELETE FROM da_object WHERE id_object=69;

DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 63 AND id_instance = 42);
DELETE FROM da_localization_element WHERE id_object = 63 AND id_instance = 42;
DELETE FROM da_object_property_value WHERE id_object_instance=42 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=63);
DELETE FROM da_object_view WHERE id_object_view=42;

DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 63 AND id_instance = 26);
DELETE FROM da_localization_element WHERE id_object = 63 AND id_instance = 26;
DELETE FROM da_object_property_value WHERE id_object_instance=26 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=63);
DELETE FROM da_object_view WHERE id_object_view=26;

UPDATE da_object SET sequence = '2', name = 'О разработчиках', object_type = '3', table_name = 'engine/admin/digitalage.php', folder_name = NULL, id_field_caption = NULL, id_field_order = NULL, order_type = '1', seq_start_value = '1', id_object_handler = NULL, id_instance_class = NULL, parent_object = '7', use_domain_isolation = '0' WHERE id_object=44;
DELETE FROM da_domain_object WHERE id_object = 44;
DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 26 AND id_instance = 143);
DELETE FROM da_localization_element WHERE id_object = 26 AND id_instance = 143;
DELETE FROM da_object_property_value WHERE id_object_instance=143 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=26);
DELETE FROM da_permissions WHERE id_permission=143;
DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 26 AND id_instance = 144);
DELETE FROM da_localization_element WHERE id_object = 26 AND id_instance = 144;
DELETE FROM da_object_property_value WHERE id_object_instance=144 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=26);
DELETE FROM da_permissions WHERE id_permission=144;

DELETE FROM da_domain_object WHERE id_object = 44;
DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 20 AND id_instance = 44);
DELETE FROM da_localization_element WHERE id_object = 20 AND id_instance = 44;
DELETE FROM da_object_property_value WHERE id_object_instance=44 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=20);
DELETE FROM da_object WHERE id_object=44;

DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 63 AND id_instance = 28);
DELETE FROM da_localization_element WHERE id_object = 63 AND id_instance = 28;
DELETE FROM da_object_property_value WHERE id_object_instance=28 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=63);
DELETE FROM da_object_view WHERE id_object_view=28;

UPDATE da_object SET sequence = '3', name = 'Выход', object_type = '3', table_name = 'engine/admin/register_off.php', folder_name = NULL, id_field_caption = NULL, id_field_order = NULL, order_type = '1', seq_start_value = '1', id_object_handler = NULL, id_instance_class = NULL, parent_object = '7', use_domain_isolation = '0' WHERE id_object=46;
DELETE FROM da_domain_object WHERE id_object = 46;
INSERT INTO da_domain_object(id_domain, id_object) 
                               VALUES(1, 46);
DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 26 AND id_instance = 3);
DELETE FROM da_localization_element WHERE id_object = 26 AND id_instance = 3;
DELETE FROM da_object_property_value WHERE id_object_instance=3 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=26);
DELETE FROM da_permissions WHERE id_permission=3;
DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 26 AND id_instance = 136);
DELETE FROM da_localization_element WHERE id_object = 26 AND id_instance = 136;
DELETE FROM da_object_property_value WHERE id_object_instance=136 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=26);
DELETE FROM da_permissions WHERE id_permission=136;

DELETE FROM da_domain_object WHERE id_object = 46;
DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 20 AND id_instance = 46);
DELETE FROM da_localization_element WHERE id_object = 20 AND id_instance = 46;
DELETE FROM da_object_property_value WHERE id_object_instance=46 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=20);
DELETE FROM da_object WHERE id_object=46;

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
