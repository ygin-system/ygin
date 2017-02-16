<?php

class m120802_162026_ngin extends CDbMigration {
  public function up() {
    $this->execute("

ALTER TABLE da_users DROP INDEX id_user;
ALTER TABLE `da_users` DROP PRIMARY KEY;

ALTER TABLE `da_users` ADD PRIMARY KEY ( `id_user` );

INSERT INTO `da_auth_item` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('list_object_525', '0', 'Просмотр списка данных объекта \"Брэнды\"', NULL, 'N;');

INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('editor', 'list_object_525');

INSERT INTO da_object (id_object, sequence, name, object_type, table_name, folder_name, id_field_caption, id_field_order, order_type, seq_start_value, id_object_handler, id_instance_class, parent_object, use_domain_isolation) VALUES ('525', '0', 'Брэнды', '1', 'pr_product_brand', 'content/product_brand', NULL, NULL, '1', '1', NULL, NULL, '518', '0');
INSERT INTO da_object_parameters (id_parameter, id_object, id_parameter_type, caption, name, field_name, not_null) VALUES ('1666', '525', '11', 'id', 'id_product_brand', 'id_product_brand', '1');

CREATE TABLE IF NOT EXISTS `pr_product_brand` (
                   `id_product_brand` INT(8) NOT NULL  AUTO_INCREMENT ,
                   PRIMARY KEY(`id_product_brand`)
                   ) ENGINE = MYISAM;

ALTER TABLE `pr_product_brand` CHANGE `id_product_brand` `id_brand` INT(8) NOT NULL ;
UPDATE da_object_parameters SET id_parameter_type = '11', caption = 'id', id_object = '525', sequence = '1', name = 'id_brand', field_name = 'id_brand', add_parameter = NULL, sql_parameter = NULL, default_value = NULL, not_null = '1', need_locale = '0', search = '0', is_unique = '0', group_type = '0', is_additional = '0', hint = NULL WHERE id_parameter=1666;

INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('1667', '2', 'Название', '525', '0', 'name', 'name', NULL, NULL, NULL, '1', '0', '0', '0', '0', '0', NULL);
ALTER TABLE `pr_product_brand` ADD `name` VARCHAR(255) NOT NULL ;
UPDATE da_object_parameters SET sequence = @maxSeq + 1 WHERE id_parameter=1667;

UPDATE da_object_parameters SET id_parameter_type = '2', caption = 'Название', id_object = '525', sequence = '280', name = 'name', field_name = 'name', add_parameter = NULL, sql_parameter = NULL, default_value = NULL, not_null = '1', need_locale = '0', search = '1', is_unique = '0', group_type = '0', is_additional = '0', hint = NULL WHERE id_parameter=1667;

INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('1668', '12', 'Родительский брэнд', '525', '0', 'id_parent', 'id_parent', '1', NULL, NULL, '0', '0', '0', '0', '0', '0', NULL);
ALTER TABLE `pr_product_brand` ADD `id_parent` INT(8) ;
UPDATE da_object_parameters SET sequence = @maxSeq + 1 WHERE id_parameter=1668;

INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('1669', '8', 'Логотип брэнда', '525', '0', 'image', 'image', '1', NULL, NULL, '0', '0', '0', '0', '0', '0', NULL);
ALTER TABLE `pr_product_brand` ADD `image` INT(8) ;
UPDATE da_object_parameters SET sequence = @maxSeq + 1 WHERE id_parameter=1669;

UPDATE da_object_parameters SET sequence = '1' WHERE id_parameter=1666;
UPDATE da_object_parameters SET sequence = '2' WHERE id_parameter=1667;
UPDATE da_object_parameters SET sequence = '3' WHERE id_parameter=1669;
UPDATE da_object_parameters SET sequence = '4' WHERE id_parameter=1668;

INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('1670', '13', 'п/п', '525', '0', 'sequence', 'sequence', '-1', NULL, NULL, '0', '0', '0', '0', '0', '0', NULL);
ALTER TABLE `pr_product_brand` ADD `sequence` INT(8) ;
UPDATE da_object_parameters SET sequence = @maxSeq + 1 WHERE id_parameter=1670;

UPDATE da_object SET sequence = '46', name = 'Брэнды', object_type = '1', table_name = 'pr_product_brand', folder_name = 'content/product_brand', id_field_caption = '1667', id_field_order = '1670', order_type = '1', seq_start_value = '1', id_object_handler = NULL, id_instance_class = NULL, parent_object = '518', use_domain_isolation = '0' WHERE id_object=525;
DELETE FROM da_domain_object WHERE id_object = 525;
INSERT INTO da_permissions (id_permission, id_group, id_object, id_permission_type) VALUES ('1166', '1', '525', '2');
INSERT INTO da_domain_object(id_domain, id_object) VALUES(1, 525);
INSERT INTO da_permissions (id_permission, id_group, id_object, id_permission_type) VALUES ('1167', '1', '525', '3');
INSERT INTO da_permissions (id_permission, id_group, id_object, id_permission_type) VALUES ('1168', '1', '525', '4');
INSERT INTO da_permissions (id_permission, id_group, id_object, id_permission_type) VALUES ('1169', '4', '525', '2');
INSERT INTO da_permissions (id_permission, id_group, id_object, id_permission_type) VALUES ('1170', '4', '525', '3');
INSERT INTO da_permissions (id_permission, id_group, id_object, id_permission_type) VALUES ('1171', '4', '525', '4');
INSERT INTO da_object_view (id_object_view, name, id_object, sql_order_by) VALUES ('2023', 'Брэнды', '525', 'sequence ASC');
INSERT INTO da_object_view_column (id_object_view_column, id_object_view, id_object, id_object_parameter, caption, id_data_type, field_name) VALUES ('6084', '2023', '525', '1667', 'Название', '2', 'name');
INSERT INTO da_object_view_column (id_object_view_column, id_object_view, id_object, id_object_parameter, caption, id_data_type, field_name) VALUES ('6085', '2023', '525', '1669', 'Логотип брэнда', '8', 'image');

INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('1671', '7', 'Брэнд', '511', '0', 'id_brand', 'id_brand', '525', NULL, NULL, '0', '0', '0', '0', '0', '0', NULL);
ALTER TABLE `pr_product` ADD `id_brand` INT(8) ;
UPDATE da_object_parameters SET sequence = @maxSeq + 1 WHERE id_parameter=1671;

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
UPDATE da_object_parameters SET sequence = '12' WHERE id_parameter=1671;
UPDATE da_object_parameters SET sequence = '13' WHERE id_parameter=1574;
UPDATE da_object_parameters SET sequence = '14' WHERE id_parameter=1616;
UPDATE da_object_parameters SET sequence = '15' WHERE id_parameter=1617;
UPDATE da_object_parameters SET sequence = '16' WHERE id_parameter=1619;

INSERT INTO da_php_script_type (id_php_script_type, id_php_script_interface, file_path, class_name, description) VALUES ('1043', '2', 'shop.widgets.BrandsWidget', 'BrandsWidget', 'Интернет-магазин » Брэнды');

UPDATE da_module SET name = 'Интернет-магазин', id_object = NULL, id_module_handler = NULL, id_module_parent = NULL, id_child_parent_object = NULL WHERE id_module=1004;
DELETE FROM da_module_view WHERE id_module = 1004;
INSERT INTO da_module_view(id_module, id_php_script_type) VALUES(1004, 1043);
INSERT INTO da_module_view(id_module, id_php_script_type) VALUES(1004, 1038);
INSERT INTO da_module_view(id_module, id_php_script_type) VALUES(1004, 1010);

INSERT INTO da_php_script (id_php_script, id_php_script_type, id_module) VALUES (1024, 1043, 1004);
DELETE FROM da_php_script_parameter WHERE id_php_script=1024;
INSERT INTO da_site_module (id_module, name, is_visible, content, html, directory, link) VALUES ('120', 'Интернет-магазин-->Брэнды', '1', NULL, NULL, NULL, '1024');

UPDATE da_site_module_template SET name = 'Каталог товаров', is_default_template = '0' WHERE id_module_template=5;
DELETE FROM da_site_module_rel WHERE id_module_template=5;
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (120, 5, 1, 2);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (111, 5, 1, 3);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (117, 5, 6, 1);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (109, 5, 1, 1);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (118, 5, 6, 2);

UPDATE da_php_script_type SET id_php_script_interface = '2', file_path = 'shop.widgets.BrandWidget', class_name = 'BrandWidget', description = 'Интернет-магазин » Брэнды' WHERE id_php_script_type=1043;

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
