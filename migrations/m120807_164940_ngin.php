<?php

class m120807_164940_ngin extends CDbMigration {
  public function up() {
    $this->execute("

INSERT INTO da_object (id_object, sequence, name, object_type, table_name, folder_name, id_field_caption, id_field_order, order_type, seq_start_value, id_object_handler, id_instance_class, parent_object, use_domain_isolation) VALUES ('527', '0', 'Плагины системы', '1', 'da_plugin', 'content/plugin', NULL, NULL, '1', '1', NULL, NULL, '1', '0');
INSERT INTO da_object_parameters (id_parameter, id_object, id_parameter_type, caption, name, field_name, not_null) VALUES ('1673', '527', '11', 'id', 'id_plugin', 'id_plugin', '1');
CREATE TABLE IF NOT EXISTS `da_plugin` (
                   `id_plugin` INT(8) NOT NULL  AUTO_INCREMENT ,
                   PRIMARY KEY(`id_plugin`)
                   ) ENGINE = MYISAM;

DELETE FROM da_domain_object WHERE id_object = 527;

INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('1674', '2', 'Название', '527', '0', 'name', 'name', NULL, NULL, NULL, '1', '0', '0', '0', '0', '0', NULL);
ALTER TABLE `da_plugin` ADD `name` VARCHAR(255) NOT NULL ;

INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('1675', '2', 'Код', '527', '0', 'code', 'code', NULL, NULL, NULL, '1', '0', '0', '0', '0', '0', NULL);
ALTER TABLE `da_plugin` ADD `code` VARCHAR(255) NOT NULL ;

INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('1676', '2', 'Статус', '527', '0', 'status', 'status', NULL, NULL, '1', '1', '0', '0', '0', '0', '0', NULL);
ALTER TABLE `da_plugin` ADD `status` VARCHAR(255) NOT NULL default '1' ;

ALTER TABLE `da_plugin` CHANGE `status` `status` INT(8) NOT NULL default '1' ;
UPDATE da_object_parameters SET id_parameter_type = '1', caption = 'Статус', id_object = '527', sequence = '282', name = 'status', field_name = 'status', add_parameter = NULL, sql_parameter = NULL, default_value = '1', not_null = '1', need_locale = '0', search = '0', is_unique = '0', group_type = '0', is_additional = '0', hint = NULL WHERE id_parameter=1676;


INSERT INTO da_object (id_object, sequence, name, object_type, table_name, folder_name, id_field_caption, id_field_order, order_type, seq_start_value, id_object_handler, id_instance_class, parent_object, use_domain_isolation) VALUES ('528', '0', 'Управление', '3', 'yiigin.controller.plugin.PluginController', NULL, NULL, NULL, '1', '1', NULL, NULL, '527', '0');

UPDATE da_object SET sequence = '48', name = 'Плагины &raquo; Управление', object_type = '3', table_name = 'yiigin.controller.plugin.PluginController', folder_name = NULL, id_field_caption = NULL, id_field_order = NULL, order_type = '1', seq_start_value = '1', id_object_handler = NULL, id_instance_class = NULL, parent_object = '527', use_domain_isolation = '0' WHERE id_object=528;

UPDATE da_object SET sequence = '48', name = 'Плагины &raquo; Управление', object_type = '3', table_name = 'yiigin/controller/plugin/PluginController', folder_name = NULL, id_field_caption = NULL, id_field_order = NULL, order_type = '1', seq_start_value = '1', id_object_handler = NULL, id_instance_class = NULL, parent_object = '527', use_domain_isolation = '0' WHERE id_object=528;

UPDATE da_object SET sequence = '48', name = 'Плагины &raquo; Управление', object_type = '3', table_name = 'yiigin/plugin', folder_name = NULL, id_field_caption = NULL, id_field_order = NULL, order_type = '1', seq_start_value = '1', id_object_handler = NULL, id_instance_class = NULL, parent_object = '527', use_domain_isolation = '0' WHERE id_object=528;

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
