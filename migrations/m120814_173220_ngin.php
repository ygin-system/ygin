<?php

class m120814_173220_ngin extends CDbMigration {
  public function up() {
    $this->execute("

ALTER TABLE `da_plugin` CHANGE `data` `config` LONGTEXT ;
UPDATE da_object_parameters SET id_parameter_type = '14', caption = 'Сериализованные настройки', id_object = '527', sequence = '283', name = 'config', field_name = 'config', add_parameter = NULL, sql_parameter = NULL, default_value = NULL, not_null = '0', need_locale = '0', search = '0', is_unique = '0', group_type = '0', is_additional = '0', hint = NULL WHERE id_parameter=1677;

INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('1681', '14', 'dat', '527', '0', 'data', 'data', NULL, NULL, NULL, '0', '0', '0', '0', '0', '0', NULL);
ALTER TABLE `da_plugin` ADD `data` LONGTEXT ;
UPDATE da_object_parameters SET sequence = @maxSeq + 1 WHERE id_parameter=1681;

UPDATE da_object_parameters SET id_parameter_type = '14', caption = 'data', id_object = '527', sequence = '286', name = 'data', field_name = 'data', add_parameter = NULL, sql_parameter = NULL, default_value = NULL, not_null = '0', need_locale = '0', search = '0', is_unique = '0', group_type = '0', is_additional = '0', hint = NULL WHERE id_parameter=1681;

UPDATE da_php_script_type SET id_php_script_interface = '13', file_path = 'engine/class/DaSiteModule.php', class_name = 'DaSiteModule', description = 'DaSiteModule' WHERE id_php_script_type=453;

ALTER TABLE `da_menu` CHANGE `id` `id` INT( 8 ) NOT NULL AUTO_INCREMENT;

ALTER TABLE `da_php_script` CHANGE `id_php_script` `id_php_script` INT( 8 ) NOT NULL AUTO_INCREMENT;

ALTER TABLE `da_site_module` CHANGE `id_module` `id_module` INT( 8 ) UNSIGNED NOT NULL AUTO_INCREMENT;

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
