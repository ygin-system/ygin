<?php

class m120820_174205_ngin extends CDbMigration {
  public function up() {
    $this->execute("

INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('424', '9', 'Видимость', '66', '0', 'visible', 'visible', NULL, NULL, '1', '0', '0', '0', '0', '0', '0', NULL);
ALTER TABLE `da_object_view_column` ADD `visible` TINYINT(1) default '1' ;


UPDATE da_object_parameters SET sequence = '1' WHERE id_parameter=415;
UPDATE da_object_parameters SET sequence = '2' WHERE id_parameter=416;
UPDATE da_object_parameters SET sequence = '3' WHERE id_parameter=417;
UPDATE da_object_parameters SET sequence = '4' WHERE id_parameter=418;
UPDATE da_object_parameters SET sequence = '5' WHERE id_parameter=424;
UPDATE da_object_parameters SET sequence = '6' WHERE id_parameter=419;
UPDATE da_object_parameters SET sequence = '7' WHERE id_parameter=420;
UPDATE da_object_parameters SET sequence = '8' WHERE id_parameter=421;
UPDATE da_object_parameters SET sequence = '9' WHERE id_parameter=422;
UPDATE da_object_parameters SET sequence = '10' WHERE id_parameter=423;

INSERT INTO da_object_view_column (id_object_view_column, id_object_view, id_object, id_object_parameter, caption, id_data_type, field_name) VALUES ('95', '44', '66', '424', 'Видимость', '9', 'visible');

UPDATE da_object_view_column SET order_no = '1' WHERE id_object_view_column=90;
UPDATE da_object_view_column SET order_no = '2' WHERE id_object_view_column=91;
UPDATE da_object_view_column SET order_no = '3' WHERE id_object_view_column=92;
UPDATE da_object_view_column SET order_no = '4' WHERE id_object_view_column=93;
UPDATE da_object_view_column SET order_no = '5' WHERE id_object_view_column=94;
UPDATE da_object_view_column SET order_no = '6' WHERE id_object_view_column=95;


DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 100 AND id_instance = 107);
DELETE FROM da_localization_element WHERE id_object = 100 AND id_instance = 107;
DELETE FROM da_object_property_value WHERE id_object_instance=107 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=100);
DELETE FROM da_menu WHERE id=107;

DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 100 AND id_instance = 110);
DELETE FROM da_localization_element WHERE id_object = 100 AND id_instance = 110;
DELETE FROM da_object_property_value WHERE id_object_instance=110 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=100);
DELETE FROM da_menu WHERE id=110;


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
