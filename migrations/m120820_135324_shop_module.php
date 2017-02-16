<?php

class m120820_135324_shop_module extends CDbMigration
{
  public function up()
  {
    $this->execute("
    -- Статусы остатков продукции
INSERT INTO da_object (id_object, sequence, name, object_type, table_name, folder_name, field_caption, id_field_caption, id_field_order, order_type, seq_start_value, id_object_handler, id_instance_class, parent_object, use_domain_isolation) VALUES ('529', '0', 'Статусы остатка продукции', '1', 'pr_remain_status', NULL, NULL, NULL, NULL, '1', '1', NULL, NULL, '518', '0');
INSERT INTO da_object_parameters (id_parameter, id_object, id_parameter_type, caption, name, field_name, not_null) VALUES ('1679', '529', '11', 'id', 'id_remain_status', 'id_remain_status', '1');
CREATE TABLE IF NOT EXISTS `pr_remain_status` (

                   `id_remain_status` INT(8) NOT NULL  AUTO_INCREMENT ,

                   PRIMARY KEY(`id_remain_status`)

                   ) ENGINE = MYISAM;
UPDATE da_object SET sequence = @maxSeq + 1 WHERE id_object=529;
DELETE FROM da_domain_object WHERE id_object = 529;
INSERT INTO da_permissions (id_permission, id_group, id_object, id_permission_type) VALUES ('1172', '1', '529', '1');
INSERT INTO da_domain_object(id_domain, id_object) VALUES(1, 529);
INSERT INTO da_permissions (id_permission, id_group, id_object, id_permission_type) VALUES ('1173', '1', '529', '2');
INSERT INTO da_permissions (id_permission, id_group, id_object, id_permission_type) VALUES ('1174', '1', '529', '3');
INSERT INTO da_permissions (id_permission, id_group, id_object, id_permission_type) VALUES ('1175', '1', '529', '4');
INSERT INTO da_permissions (id_permission, id_group, id_object, id_permission_type) VALUES ('1176', '4', '529', '1');
INSERT INTO da_permissions (id_permission, id_group, id_object, id_permission_type) VALUES ('1177', '4', '529', '2');
INSERT INTO da_permissions (id_permission, id_group, id_object, id_permission_type) VALUES ('1178', '4', '529', '3');
INSERT INTO da_permissions (id_permission, id_group, id_object, id_permission_type) VALUES ('1179', '4', '529', '4');

INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('1680', '2', 'Название', '529', '0', 'name', 'name', NULL, NULL, NULL, '1', '0', '0', '0', '0', '0', NULL);
ALTER TABLE `pr_remain_status` ADD `name` VARCHAR(255) NOT NULL ;
UPDATE da_object_parameters SET sequence = @maxSeq + 1 WHERE id_parameter=1680;

UPDATE da_object SET sequence = '49', name = 'Статусы остатка продукции', object_type = '1', table_name = 'pr_remain_status', folder_name = NULL, field_caption = NULL, id_field_caption = '1680', id_field_order = '1679', order_type = '1', seq_start_value = '1', id_object_handler = NULL, id_instance_class = NULL, parent_object = '518', use_domain_isolation = '0' WHERE id_object=529;
DELETE FROM da_domain_object WHERE id_object = 529;
INSERT INTO da_domain_object(id_domain, id_object)
                               VALUES(1, 529);

UPDATE da_object SET sequence = '49', name = 'Статусы остатка продукции', object_type = '1', table_name = 'pr_remain_status', folder_name = NULL, field_caption = NULL, id_field_caption = '1680', id_field_order = '1679', order_type = '1', seq_start_value = '1', id_object_handler = NULL, id_instance_class = NULL, parent_object = '518', use_domain_isolation = '0' WHERE id_object=529;
DELETE FROM da_domain_object WHERE id_object = 529;
INSERT INTO da_domain_object(id_domain, id_object)
                               VALUES(1, 529);
INSERT INTO da_object_view (id_object_view, name, id_object, sql_order_by) VALUES ('2024', 'Статусы остатка продукции', '529', 'id_remain_status ASC');
INSERT INTO da_object_view_column (id_object_view_column, id_object_view, id_object, id_object_parameter, caption, id_data_type, field_name) VALUES ('6086', '2024', '529', '1680', 'Название', '2', 'name');

-- RBAC
INSERT INTO `da_auth_item` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('list_object_529', 0, 'Просмотр списка данных объекта \"Статусы остатка продукции\"', NULL, 'N;');
INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES
('editor', 'list_object_529');

-- Экземпляры
INSERT INTO pr_remain_status (id_remain_status, name) VALUES ('1', 'Под заказ');
INSERT INTO pr_remain_status (id_remain_status, name) VALUES ('2', 'последняя штука');
UPDATE pr_remain_status SET name = 'под заказ' WHERE id_remain_status=1;
INSERT INTO pr_remain_status (id_remain_status, name) VALUES ('3', 'мало');
INSERT INTO pr_remain_status (id_remain_status, name) VALUES ('4', 'средне');
INSERT INTO pr_remain_status (id_remain_status, name) VALUES ('5', 'много');
--
-- Еще пару новых свойств
INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('1683', '1', 'Мин. значение по-умолчанию', '529', '0', 'min_value', 'min_value', NULL, NULL, NULL, '1', '0', '0', '0', '0', '0', NULL);
ALTER TABLE `pr_remain_status` ADD `min_value` INT(8) NOT NULL ;
UPDATE da_object_parameters SET sequence = @maxSeq + 1 WHERE id_parameter=1683;

INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('1682', '1', 'Макс. значение по-умолчанию', '529', '0', 'max_value', 'max_value', NULL, NULL, NULL, '1', '0', '0', '0', '0', '0', NULL);
ALTER TABLE `pr_remain_status` ADD `max_value` INT(8) NOT NULL ;
UPDATE da_object_parameters SET sequence = @maxSeq + 1 WHERE id_parameter=1682;
--
-- Дефолтные значения для статусов
UPDATE pr_remain_status SET name = 'под заказ', min_value = '-999999999', max_value = '0' WHERE id_remain_status=1;
UPDATE pr_remain_status SET name = 'последняя штука', min_value = '0', max_value = '1' WHERE id_remain_status=2;
UPDATE pr_remain_status SET name = 'мало', min_value = '1', max_value = '5' WHERE id_remain_status=3;
UPDATE pr_remain_status SET name = 'средне', min_value = '5', max_value = '10' WHERE id_remain_status=4;
UPDATE pr_remain_status SET name = 'много', min_value = '10', max_value = '999999999' WHERE id_remain_status=5;
--
    ");
  }

  public function down()
  {
    echo "m120820_135324_shop_module does not support migration down.\n";
    return false;
  }

  /*
  // Use safeUp/safeDown to do migration with transaction
  public function safeUp()
  {
  }

  public function safeDown()
  {
  }
  */
}