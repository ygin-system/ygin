<?php

class m121009_153555_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE da_object SET name = 'Меню', folder_name = 'content/menu' WHERE id_object=100");
    $this->execute("UPDATE da_object_parameters SET id_parameter_type = '2', caption = 'Спрашивающий', id_object = '512', sequence = '3', name = 'name', field_name = 'name', add_parameter = NULL, sql_parameter = NULL, default_value = NULL, not_null = '1', need_locale = '0', search = '0', is_unique = '0', group_type = '0', is_additional = '0', hint = NULL WHERE id_parameter=1580");
    $this->execute("UPDATE da_object_parameters SET id_parameter_type = '14', caption = 'Вопрос', id_object = '512', sequence = '5', name = 'question', field_name = 'question', add_parameter = NULL, sql_parameter = NULL, default_value = NULL, not_null = '1', need_locale = '0', search = '1', is_unique = '0', group_type = '0', is_additional = '0', hint = NULL WHERE id_parameter=1581");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false);
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
