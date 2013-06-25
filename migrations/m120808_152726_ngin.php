<?php

class m120808_152726_ngin extends CDbMigration {
  public function up() {
    $this->execute("

INSERT INTO `da_auth_item` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('list_object_528', '0', 'Управление объектом Плагины системы', NULL, 'N;');

INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('dev', 'list_object_528');


INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('1677', '14', 'Сериализованные настройки', '527', '0', 'data', 'data', NULL, NULL, NULL, '0', '0', '0', '0', '0', '0', NULL);
ALTER TABLE `da_plugin` ADD `data` LONGTEXT ;
UPDATE da_object_parameters SET sequence = @maxSeq + 1 WHERE id_parameter=1677;

UPDATE da_object SET sequence = '48', name = 'Настройка плагинов', object_type = '3', table_name = 'yiigin/plugin', folder_name = NULL, id_field_caption = NULL, id_field_order = NULL, order_type = '1', seq_start_value = '1', id_object_handler = NULL, id_instance_class = NULL, parent_object = '527', use_domain_isolation = '0' WHERE id_object=528;
DELETE FROM da_domain_object WHERE id_object = 528;

INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('1678', '2', 'Класс плагина', '527', '0', 'class_name', 'class_name', NULL, NULL, NULL, '1', '0', '0', '0', '0', '0', NULL);
ALTER TABLE `da_plugin` ADD `class_name` VARCHAR(255) NOT NULL ;
UPDATE da_object_parameters SET sequence = @maxSeq + 1 WHERE id_parameter=1678;

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
