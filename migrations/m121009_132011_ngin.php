<?php

class m121009_132011_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 51 AND id_instance = 6)");
    $this->execute("DELETE FROM da_localization_element WHERE id_object = 51 AND id_instance = 6");
    $this->execute("DELETE FROM da_object_property_value WHERE id_object_instance=6 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=51)");
    $this->execute("DELETE FROM da_job WHERE id_job=6");
    $this->execute("DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 51 AND id_instance = 7)");
    $this->execute("DELETE FROM da_localization_element WHERE id_object = 51 AND id_instance = 7");
    $this->execute("DELETE FROM da_object_property_value WHERE id_object_instance=7 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=51)");
    $this->execute("DELETE FROM da_job WHERE id_job=7");
    $this->execute("DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 51 AND id_instance = 8)");
    $this->execute("DELETE FROM da_localization_element WHERE id_object = 51 AND id_instance = 8");
    $this->execute("DELETE FROM da_object_property_value WHERE id_object_instance=8 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=51)");
    $this->execute("DELETE FROM da_job WHERE id_job=8");
    $this->execute("DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 51 AND id_instance = 9)");
    $this->execute("DELETE FROM da_localization_element WHERE id_object = 51 AND id_instance = 9");
    $this->execute("DELETE FROM da_object_property_value WHERE id_object_instance=9 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=51)");
    $this->execute("DELETE FROM da_job WHERE id_job=9");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false);
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
