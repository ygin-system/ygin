<?php

class m120731_013940_ngin extends CDbMigration {
  public function up() {
    $this->execute("

UPDATE da_object_view_column SET id_object_view = '2000', id_object = '500', caption = 'Фото', order_no = '20', id_object_parameter = NULL, id_data_type = '10', field_name = '-', handler = '1001' WHERE id_object_view_column=6003;

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
