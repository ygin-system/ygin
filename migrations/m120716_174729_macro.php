<?php

class m120716_174729_macro extends CDbMigration {
  public function up() {
    $this->execute("

INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('122', '9', 'Активен', '24', '0', 'active', 'active', NULL, NULL, '1', '0', '0', '0', '0', '0', '0', 'Есть ли возможность пройти авторизацию и пользоваться сервисами сайта');
ALTER TABLE `da_users` ADD `active` TINYINT(1) default '1' ;


INSERT INTO da_object_view_column (id_object_view_column, id_object_view, id_object, caption, order_no, id_object_parameter, id_data_type, field_name, handler) VALUES ('37', '6', '24', 'Активен', '0', '122', '9', 'active', NULL);

UPDATE da_object_view_column SET order_no = '1' WHERE id_object_view_column=11;
UPDATE da_object_view_column SET order_no = '2' WHERE id_object_view_column=12;
UPDATE da_object_view_column SET order_no = '3' WHERE id_object_view_column=13;
UPDATE da_object_view_column SET order_no = '4' WHERE id_object_view_column=14;
UPDATE da_object_view_column SET order_no = '5' WHERE id_object_view_column=37;

UPDATE da_object_parameters SET sequence = '1' WHERE id_parameter=93;
UPDATE da_object_parameters SET sequence = '2' WHERE id_parameter=89;
UPDATE da_object_parameters SET sequence = '3' WHERE id_parameter=88;
UPDATE da_object_parameters SET sequence = '4' WHERE id_parameter=122;
UPDATE da_object_parameters SET sequence = '5' WHERE id_parameter=90;
UPDATE da_object_parameters SET sequence = '6' WHERE id_parameter=91;
UPDATE da_object_parameters SET sequence = '7' WHERE id_parameter=92;
UPDATE da_object_parameters SET sequence = '8' WHERE id_parameter=239;
UPDATE da_object_parameters SET sequence = '9' WHERE id_parameter=238;
UPDATE da_object_parameters SET sequence = '10' WHERE id_parameter=123;



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
