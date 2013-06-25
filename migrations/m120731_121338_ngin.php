<?php

class m120731_121338_ngin extends CDbMigration {
  public function up() {
    $this->execute("

DELETE FROM da_users WHERE name IN ('sanchezzzov', 'balas_ks', 'petrov_ro');

INSERT INTO `da_users` (`id_user`, `id_group`, `name`, `user_password`, `mail`, `full_name`, `rid`, `create_date`, `count_post`) VALUES
(60, 1, 'sanchezzzov', '9bc4683b5a29b63a5c11cad2ccda9fa9', NULL, 'Александр', NULL, 1326352963, 0),
(61, 1, 'balas_ks', '4d5b8a355e0474e37bc48da006abe637', NULL, 'Ксения Сергевна', NULL, 1339762276, 0),
(62, 1, 'petrov_ro', '0da27e1a857691532cebf861d3450482', NULL, 'Гость', NULL, 1340610076, 0);


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
