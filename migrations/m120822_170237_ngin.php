<?php

class m120822_170237_ngin extends CDbMigration {
  public function up() {
    $this->execute("

DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 100 AND id_instance = 133);
DELETE FROM da_localization_element WHERE id_object = 100 AND id_instance = 133;
DELETE FROM da_object_property_value WHERE id_object_instance=133 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=100);
DELETE FROM da_menu WHERE id=133;

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
