<?php

class m120720_223512_ngin extends CDbMigration {
  public function up() {
    $this->execute("

INSERT INTO da_object_view_column (id_object_view_column, id_object_view, id_object, caption, order_no, id_object_parameter, id_data_type, field_name, handler) VALUES ('6081', '2017', '519', 'Дата', '0', '1626', '4', 'create_date', NULL);
UPDATE da_object_view_column SET order_no = @maxSeq + 1 WHERE id_object_view_column=6081;

UPDATE da_object_view_column SET order_no = '1' WHERE id_object_view_column=6081;
UPDATE da_object_view_column SET order_no = '2' WHERE id_object_view_column=6060;
UPDATE da_object_view_column SET order_no = '3' WHERE id_object_view_column=6061;
UPDATE da_object_view_column SET order_no = '4' WHERE id_object_view_column=6062;
UPDATE da_object_view_column SET order_no = '5' WHERE id_object_view_column=6063;

UPDATE da_site_module_template SET name = 'Основной', is_default_template = '1' WHERE id_module_template=1;
DELETE FROM da_site_module_rel WHERE id_module_template=1;
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (114, 1, 1, 2);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (117, 1, 6, 1);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (100, 1, 1, 1);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (118, 1, 6, 2);

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
