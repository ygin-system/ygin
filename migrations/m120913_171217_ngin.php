<?php

class m120913_171217_ngin extends CDbMigration {
  public function up() {
    $this->execute("

UPDATE da_php_script_type SET id_php_script_interface = '2', file_path = 'news.widgets.news.NewsWidget', class_name = 'NewsWidget', description = 'Новости » Список последних на главной' WHERE id_php_script_type=1005;

UPDATE da_php_script_type SET id_php_script_interface = '2', file_path = 'shop.widgets.cart.CartWidget', class_name = 'CartWidget', description = 'Интернет-магазин » Корзина' WHERE id_php_script_type=1010;

UPDATE da_php_script_type SET id_php_script_interface = '2', file_path = 'user.widgets.login.LoginWidget', class_name = 'LoginWidget', description = 'Авторизация' WHERE id_php_script_type=1032;

UPDATE da_php_script_type SET id_php_script_interface = '2', file_path = 'ngin.widgets.vitrine.VitrineWidget', class_name = 'VitrineWidget', description = 'Витрина' WHERE id_php_script_type=1039;

UPDATE da_php_script_type SET id_php_script_interface = '2', file_path = 'vote.widgets.VoteWidget', class_name = 'VoteWidget', description = 'Голосование' WHERE id_php_script_type=1041;

UPDATE da_php_script_type SET id_php_script_interface = '2', file_path = 'menu.widgets.MenuWidget', class_name = 'MenuWidget', description = 'Меню' WHERE id_php_script_type=1042;

UPDATE `da_plugin` SET `class_name`='ngin.widgets.vitrine.VitrinePlugin' WHERE `da_plugin`.`id_plugin`=12;


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
