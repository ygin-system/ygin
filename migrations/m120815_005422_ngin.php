<?php

class m120815_005422_ngin extends CDbMigration {
  public function up() {
    $this->execute("

UPDATE da_object_view SET id_parent = NULL, id_object = '505', name = 'Консультации » Вопросы', order_no = '1', visible = '0', sql_select = 'IF(LENGTH(ask)<300, ask, CONCAT(SUBSTR(ask, 1, 300), \'...\')) AS short_ask', sql_from = NULL, sql_where = NULL, sql_order_by = 'ask_date DESC', count_data = '50', icon_class = NULL WHERE id_object_view=2004;

UPDATE da_object_view SET id_parent = NULL, id_object = '507', name = 'Консультации » Специалисты', order_no = '1', visible = '0', sql_select = NULL, sql_from = NULL, sql_where = NULL, sql_order_by = 'name ASC', count_data = '50', icon_class = NULL WHERE id_object_view=2006;

UPDATE da_object_view SET id_parent = NULL, id_object = '508', name = 'Консультации » Специализации', order_no = '1', visible = '0', sql_select = NULL, sql_from = NULL, sql_where = NULL, sql_order_by = 'specialization ASC', count_data = '50', icon_class = NULL WHERE id_object_view=2007;

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
