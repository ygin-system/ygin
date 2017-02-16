<?php

class m120828_174955_ngin extends CDbMigration {
  public function up() {
    $this->execute("

INSERT INTO da_object (id_object, sequence, name, object_type, table_name, folder_name, field_caption, id_field_caption, id_field_order, order_type, seq_start_value, id_object_handler, id_instance_class, parent_object, use_domain_isolation) VALUES ('530', '0', 'Отзывы клиентов', '1', 'pr_client_review', NULL, NULL, NULL, NULL, '1', '1', NULL, NULL, '4', '0');
INSERT INTO da_object_parameters (id_parameter, id_object, id_parameter_type, caption, name, field_name, not_null) VALUES ('1684', '530', '11', 'id', 'id_client_review', 'id_client_review', '1');
CREATE TABLE IF NOT EXISTS `pr_client_review` (

                   `id_client_review` INT(8) NOT NULL  AUTO_INCREMENT ,

                   PRIMARY KEY(`id_client_review`)

                   ) ENGINE = MYISAM;
UPDATE da_object SET sequence = @maxSeq + 1 WHERE id_object=530;
DELETE FROM da_domain_object WHERE id_object = 530;

INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('1685', '2', 'ФИО', '530', '0', 'name', 'name', NULL, NULL, NULL, '1', '0', '0', '0', '0', '0', NULL);
ALTER TABLE `pr_client_review` ADD `name` VARCHAR(255) NOT NULL ;
UPDATE da_object_parameters SET sequence = @maxSeq + 1 WHERE id_parameter=1685;

INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('1686', '4', 'Дата', '530', '0', 'create_date', 'create_date', NULL, NULL, NULL, '1', '0', '0', '0', '0', '0', NULL);
ALTER TABLE `pr_client_review` ADD `create_date` INT(10) NOT NULL ;
UPDATE da_object_parameters SET sequence = @maxSeq + 1 WHERE id_parameter=1686;

INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('1687', '14', 'Текст отзыва', '530', '0', 'review', 'review', NULL, NULL, NULL, '1', '0', '0', '0', '0', '0', NULL);
ALTER TABLE `pr_client_review` ADD `review` LONGTEXT NOT NULL ;
UPDATE da_object_parameters SET sequence = @maxSeq + 1 WHERE id_parameter=1687;

INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('1688', '2', 'ip', '530', '0', 'ip', 'ip', NULL, NULL, NULL, '1', '0', '0', '0', '0', '0', NULL);
ALTER TABLE `pr_client_review` ADD `ip` VARCHAR(255) NOT NULL ;
UPDATE da_object_parameters SET sequence = @maxSeq + 1 WHERE id_parameter=1688;

INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('1689', '9', 'Видимость на сайте', '530', '0', 'visible', 'visible', NULL, NULL, NULL, '0', '0', '0', '0', '0', '0', NULL);
ALTER TABLE `pr_client_review` ADD `visible` TINYINT(1) ;
UPDATE da_object_parameters SET sequence = @maxSeq + 1 WHERE id_parameter=1689;

INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('1690', '2', 'Контакты клиента', '530', '0', 'contact', 'contact', NULL, NULL, NULL, '0', '0', '0', '0', '0', '0', NULL);
ALTER TABLE `pr_client_review` ADD `contact` VARCHAR(255) ;
UPDATE da_object_parameters SET sequence = @maxSeq + 1 WHERE id_parameter=1690;

UPDATE da_object SET sequence = '50', name = 'Отзывы клиентов', object_type = '1', table_name = 'pr_client_review', folder_name = NULL, field_caption = 'name', id_field_caption = '1685', id_field_order = '1686', order_type = '2', seq_start_value = '1', id_object_handler = NULL, id_instance_class = NULL, parent_object = '4', use_domain_isolation = '0' WHERE id_object=530;
DELETE FROM da_domain_object WHERE id_object = 530;
INSERT INTO da_permissions (id_permission, id_group, id_object, id_permission_type) VALUES ('1180', '1', '530', '2');
INSERT INTO da_domain_object(id_domain, id_object) VALUES(1, 530);
INSERT INTO da_permissions (id_permission, id_group, id_object, id_permission_type) VALUES ('1181', '1', '530', '3');
INSERT INTO da_permissions (id_permission, id_group, id_object, id_permission_type) VALUES ('1182', '1', '530', '4');
INSERT INTO da_permissions (id_permission, id_group, id_object, id_permission_type) VALUES ('1183', '4', '530', '2');
INSERT INTO da_permissions (id_permission, id_group, id_object, id_permission_type) VALUES ('1184', '4', '530', '3');
INSERT INTO da_permissions (id_permission, id_group, id_object, id_permission_type) VALUES ('1185', '4', '530', '4');
INSERT INTO da_object_view (id_object_view, name, id_object, sql_order_by) VALUES ('2025', 'Отзывы клиентов', '530', 'create_date DESC');
INSERT INTO da_object_view_column (id_object_view_column, id_object_view, id_object, id_object_parameter, caption, id_data_type, field_name) VALUES ('6087', '2025', '530', '1685', 'ФИО', '2', 'name');
INSERT INTO da_object_view_column (id_object_view_column, id_object_view, id_object, id_object_parameter, caption, id_data_type, field_name) VALUES ('6088', '2025', '530', '1686', 'Дата', '4', 'create_date');
INSERT INTO da_object_view_column (id_object_view_column, id_object_view, id_object, id_object_parameter, caption, id_data_type, field_name) VALUES ('6089', '2025', '530', '1687', 'Текст отзыва', '14', 'review');
INSERT INTO da_object_view_column (id_object_view_column, id_object_view, id_object, id_object_parameter, caption, id_data_type, field_name) VALUES ('6090', '2025', '530', '1689', 'Видимость на сайте', '9', 'visible');


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
