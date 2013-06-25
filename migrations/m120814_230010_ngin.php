<?php

class m120814_230010_ngin extends CDbMigration {
  public function up() {
    $this->execute("

UPDATE da_object SET sequence = '48', name = 'Настройка плагинов', object_type = '3', table_name = 'yiigin/plugin/plugin', folder_name = NULL, field_caption = NULL, id_field_caption = NULL, id_field_order = NULL, order_type = '1', seq_start_value = '1', id_object_handler = NULL, id_instance_class = NULL, parent_object = '527', use_domain_isolation = '0' WHERE id_object=528;
DELETE FROM da_domain_object WHERE id_object = 528;

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
