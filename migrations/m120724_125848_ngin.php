<?php

class m120724_125848_ngin extends CDbMigration {
  public function up() {
    $this->execute("

INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('1637', '9', 'Видимость', '509', '0', 'visible', 'visible', NULL, NULL, '1', '0', '0', '0', '0', '0', '0', NULL);
ALTER TABLE `pr_product_category` ADD `visible` TINYINT(1) default '1' ;

UPDATE da_object_parameters SET sequence = '1' WHERE id_parameter=1636;
UPDATE da_object_parameters SET sequence = '2' WHERE id_parameter=1552;
UPDATE da_object_parameters SET sequence = '3' WHERE id_parameter=1553;
UPDATE da_object_parameters SET sequence = '4' WHERE id_parameter=1637;
UPDATE da_object_parameters SET sequence = '5' WHERE id_parameter=1554;
UPDATE da_object_parameters SET sequence = '6' WHERE id_parameter=1555;
UPDATE da_object_parameters SET sequence = '7' WHERE id_parameter=1557;

INSERT INTO da_object_view_column (id_object_view_column, id_object_view, id_object, caption, order_no, id_object_parameter, id_data_type, field_name, handler) VALUES ('6082', '2008', '509', 'Видимость', '0', '1637', '9', 'visible', NULL);

UPDATE da_object_view_column SET order_no = '1' WHERE id_object_view_column=6080;
UPDATE da_object_view_column SET order_no = '2' WHERE id_object_view_column=6029;
UPDATE da_object_view_column SET order_no = '3' WHERE id_object_view_column=6030;
UPDATE da_object_view_column SET order_no = '4' WHERE id_object_view_column=6082;

INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('1663', '9', 'Видимость', '511', '0', 'visible', 'visible', NULL, NULL, '1', '0', '0', '0', '0', '0', '0', NULL);
ALTER TABLE `pr_product` ADD `visible` TINYINT(1) default '1' ;

INSERT INTO da_object_view_column (id_object_view_column, id_object_view, id_object, caption, order_no, id_object_parameter, id_data_type, field_name, handler) VALUES ('6083', '2010', '511', 'Видимость', '0', '1663', '9', 'visible', NULL);

UPDATE da_object_view_column SET order_no = '1' WHERE id_object_view_column=6037;
UPDATE da_object_view_column SET order_no = '2' WHERE id_object_view_column=6038;
UPDATE da_object_view_column SET order_no = '3' WHERE id_object_view_column=6033;
UPDATE da_object_view_column SET order_no = '4' WHERE id_object_view_column=6036;
UPDATE da_object_view_column SET order_no = '5' WHERE id_object_view_column=6059;
UPDATE da_object_view_column SET order_no = '6' WHERE id_object_view_column=6083;

UPDATE da_object_parameters SET sequence = '1' WHERE id_parameter=1564;
UPDATE da_object_parameters SET sequence = '2' WHERE id_parameter=1565;
UPDATE da_object_parameters SET sequence = '3' WHERE id_parameter=1566;
UPDATE da_object_parameters SET sequence = '4' WHERE id_parameter=1567;
UPDATE da_object_parameters SET sequence = '5' WHERE id_parameter=1663;
UPDATE da_object_parameters SET sequence = '6' WHERE id_parameter=1576;
UPDATE da_object_parameters SET sequence = '7' WHERE id_parameter=1568;
UPDATE da_object_parameters SET sequence = '8' WHERE id_parameter=1569;
UPDATE da_object_parameters SET sequence = '9' WHERE id_parameter=1570;
UPDATE da_object_parameters SET sequence = '10' WHERE id_parameter=1571;
UPDATE da_object_parameters SET sequence = '11' WHERE id_parameter=1573;
UPDATE da_object_parameters SET sequence = '12' WHERE id_parameter=1574;
UPDATE da_object_parameters SET sequence = '13' WHERE id_parameter=1616;
UPDATE da_object_parameters SET sequence = '14' WHERE id_parameter=1617;
UPDATE da_object_parameters SET sequence = '15' WHERE id_parameter=1619;


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
