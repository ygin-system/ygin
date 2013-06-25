<?php

class m120727_000458_ngin extends CDbMigration {
  public function up() {
    $this->execute("

UPDATE da_object_parameters SET caption = 'Создать представление' WHERE id_parameter=62;

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
