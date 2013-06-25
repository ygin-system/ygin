<?php

class m120820_182032_ngin extends CDbMigration {
  public function up() {
    $this->execute("

DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 63 AND id_instance = 56);
DELETE FROM da_localization_element WHERE id_object = 63 AND id_instance = 56;
DELETE FROM da_object_property_value WHERE id_object_instance=56 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=63);
DELETE FROM da_object_view WHERE id_object_view=56;

DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 63 AND id_instance = 72);
DELETE FROM da_localization_element WHERE id_object = 63 AND id_instance = 72;
DELETE FROM da_object_property_value WHERE id_object_instance=72 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=63);
DELETE FROM da_object_view WHERE id_object_view=72;

DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 63 AND id_instance = 70);
DELETE FROM da_localization_element WHERE id_object = 63 AND id_instance = 70;
DELETE FROM da_object_property_value WHERE id_object_instance=70 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=63);
DELETE FROM da_object_view WHERE id_object_view=70;

DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 63 AND id_instance = 40);
DELETE FROM da_localization_element WHERE id_object = 63 AND id_instance = 40;
DELETE FROM da_object_property_value WHERE id_object_instance=40 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=63);
DELETE FROM da_object_view WHERE id_object_view=40;

DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 63 AND id_instance = 25);
DELETE FROM da_localization_element WHERE id_object = 63 AND id_instance = 25;
DELETE FROM da_object_property_value WHERE id_object_instance=25 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=63);
DELETE FROM da_object_view WHERE id_object_view=25;

DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 63 AND id_instance = 71);
DELETE FROM da_localization_element WHERE id_object = 63 AND id_instance = 71;
DELETE FROM da_object_property_value WHERE id_object_instance=71 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=63);
DELETE FROM da_object_view WHERE id_object_view=71;

DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 63 AND id_instance = 75);
DELETE FROM da_localization_element WHERE id_object = 63 AND id_instance = 75;
DELETE FROM da_object_property_value WHERE id_object_instance=75 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=63);
DELETE FROM da_object_view WHERE id_object_view=75;

DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 63 AND id_instance = 74);
DELETE FROM da_localization_element WHERE id_object = 63 AND id_instance = 74;
DELETE FROM da_object_property_value WHERE id_object_instance=74 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=63);
DELETE FROM da_object_view WHERE id_object_view=74;

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
