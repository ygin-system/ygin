<?php

class m130606_160849_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE `da_object` SET `id_object`='ygin.menu', `name`='Меню', `id_field_order`='', `order_type`=1, `table_name`='da_menu', `id_field_caption`='', `object_type`=1, `folder_name`='content/menu', `parent_object`=4, `sequence`=1, `use_domain_isolation`=0, `field_caption`='name', `yii_model`='Menu' WHERE `da_object`.`id_object`='100'");
    $this->execute("DELETE FROM `da_auth_item` WHERE name='create_object_100'");
    $this->execute("DELETE FROM `da_auth_item` WHERE name='delete_object_100'");
    $this->execute("DELETE FROM `da_auth_item` WHERE name='edit_object_100'");
    $this->execute("DELETE FROM `da_auth_item` WHERE name='list_object_100'");
    $this->execute("INSERT INTO `da_auth_item` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('edit_object_ygin.menu', 0, 'Операция изменения для объекта Меню', NULL, 'N;')");
    $this->execute("INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('dev', 'edit_object_ygin.menu')");
    $this->execute("INSERT INTO `da_auth_item` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('delete_object_ygin.menu', 0, 'Операция удаления для объекта Меню', NULL, 'N;')");
    $this->execute("INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('dev', 'delete_object_ygin.menu')");
    $this->execute("INSERT INTO `da_auth_item` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('create_object_ygin.menu', 0, 'Операция создания для объекта Меню', NULL, 'N;')");
    $this->execute("INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('dev', 'create_object_ygin.menu')");
    $this->execute("INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('editor', 'edit_object_ygin.menu')");
    $this->execute("INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('editor', 'delete_object_ygin.menu')");
    $this->execute("INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('editor', 'create_object_ygin.menu')");
    $this->execute("INSERT INTO `da_auth_item` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('list_object_ygin.menu', 0, 'Просмотр списка данных объекта Меню', NULL, 'N;')");
    $this->execute("INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('dev', 'list_object_ygin.menu')");
    $this->execute("INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('editor', 'list_object_ygin.menu')");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`='ygin.menu' WHERE id_object='100'");
    $this->execute("UPDATE `da_object_parameters` SET `add_parameter`='ygin.menu' WHERE id_parameter_type=7 AND add_parameter='100'");
    $this->execute("UPDATE `da_object_view` SET `id_object`='ygin.menu' WHERE id_object='100'");
    $this->execute("UPDATE `da_object_view_column` SET `id_object`='ygin.menu' WHERE id_object='100'");
    $this->execute("UPDATE `da_files` SET `id_object`='ygin.menu' WHERE id_object='100'");
    $this->execute("UPDATE `da_object` SET `id_object`='22', `name`='Типы данных', `id_field_order`='105', `order_type`=1, `table_name`='da_object_parameter_type', `id_field_caption`='86', `object_type`=1, `folder_name`=NULL, `parent_object`=1, `sequence`=13, `use_domain_isolation`=0, `field_caption`='name', `yii_model`=NULL WHERE `da_object`.`id_object`='22'");
    $this->execute("INSERT INTO `da_auth_item` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('edit_object_22', 0, 'Операция изменения для объекта Типы данных', NULL, 'N;')");
    $this->execute("INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('dev', 'edit_object_22')");
    $this->execute("INSERT INTO `da_auth_item` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('delete_object_22', 0, 'Операция удаления для объекта Типы данных', NULL, 'N;')");
    $this->execute("INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('dev', 'delete_object_22')");
    $this->execute("INSERT INTO `da_auth_item` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('create_object_22', 0, 'Операция создания для объекта Типы данных', NULL, 'N;')");
    $this->execute("INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('dev', 'create_object_22')");
    $this->execute("INSERT INTO `da_auth_item` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('list_object_22', 0, 'Просмотр списка данных объекта Типы данных', NULL, 'N;')");
    $this->execute("INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('dev', 'list_object_22')");
    $this->execute("UPDATE `da_object` SET `id_object`='22', `name`='Типы данных', `id_field_order`='105', `order_type`=1, `table_name`='da_object_parameter_type', `id_field_caption`='86', `object_type`=1, `folder_name`=NULL, `parent_object`=1, `sequence`=13, `use_domain_isolation`=0, `field_caption`='name', `yii_model`=NULL WHERE `da_object`.`id_object`='22'");
    $this->execute("INSERT INTO `da_object_view` (`order_no`, `visible`, `count_data`, `id_object_view`, `name`, `id_object`, `sql_order_by`) VALUES (1, 1, 50, '22.view.main', 'Типы данных', '22', 'sequence')");
    $this->execute("INSERT INTO `da_object_view_column` (`order_no`, `id_data_type`, `visible`, `id_object_view_column`, `id_object_view`, `id_object`, `id_object_parameter`, `caption`, `field_name`) VALUES (1, 2, 1, '22.view.main.name', '22.view.main', '22', '86', 'Название типа данных', 'name')");
    $this->execute("INSERT INTO `da_object_parameters` (`id_parameter_type`, `sequence`, `not_null`, `need_locale`, `search`, `is_additional`, `id_object`, `group_type`, `id_parameter`, `caption`, `field_name`, `widget`, `add_parameter`, `sql_parameter`, `default_value`, `is_unique`, `hint`) VALUES (2, 0, 0, 0, 0, 0, '22', 0, 'ygin.objectParameterType.sqlType', 'sql тип', 'sql_type', NULL, '0', NULL, NULL, 0, '')");
    $this->execute("UPDATE da_object_parameters SET sequence = 287 WHERE id_parameter='ygin.objectParameterType.sqlType'");
    $this->execute("UPDATE `da_object_parameter_type` SET `id_parameter_type`=11, `sequence`=1, `name`='Первичный ключ', `sql_type`='INT(8)' WHERE `da_object_parameter_type`.`id_parameter_type`=11");
    $this->execute("UPDATE `da_object_parameter_type` SET `id_parameter_type`=1, `sequence`=2, `name`='Число', `sql_type`='INT(8)' WHERE `da_object_parameter_type`.`id_parameter_type`=1");
    $this->execute("UPDATE `da_object_parameter_type` SET `id_parameter_type`=2, `sequence`=3, `name`='Строка', `sql_type`='VARCHAR(255)' WHERE `da_object_parameter_type`.`id_parameter_type`=2");
    $this->execute("UPDATE `da_object_parameter_type` SET `id_parameter_type`=4, `sequence`=4, `name`='Дата', `sql_type`='INT(10) UNSIGNED' WHERE `da_object_parameter_type`.`id_parameter_type`=4");
    $this->execute("UPDATE `da_object_parameter_type` SET `id_parameter_type`=9, `sequence`=5, `name`='Логический (bool)', `sql_type`='TINYINT(1)' WHERE `da_object_parameter_type`.`id_parameter_type`=9");
    $this->execute("UPDATE `da_object_parameter_type` SET `id_parameter_type`=14, `sequence`=6, `name`='Текст (text area)', `sql_type`='LONGTEXT' WHERE `da_object_parameter_type`.`id_parameter_type`=14");
    $this->execute("UPDATE `da_object_parameter_type` SET `id_parameter_type`=3, `sequence`=7, `name`='HTML-редактор', `sql_type`='LONGTEXT' WHERE `da_object_parameter_type`.`id_parameter_type`=3");
    $this->execute("UPDATE `da_object_parameter_type` SET `id_parameter_type`=8, `sequence`=8, `name`='Файл', `sql_type`='INT(8)' WHERE `da_object_parameter_type`.`id_parameter_type`=8");
    $this->execute("UPDATE `da_object_parameter_type` SET `id_parameter_type`=6, `sequence`=10, `name`='Справочник', `sql_type`='INT(8)' WHERE `da_object_parameter_type`.`id_parameter_type`=6");
    $this->execute("UPDATE `da_object_parameter_type` SET `id_parameter_type`=7, `sequence`=11, `name`='Внешний ключ (Объект)', `sql_type`='INT(8)' WHERE `da_object_parameter_type`.`id_parameter_type`=7");
    $this->execute("UPDATE `da_object_parameter_type` SET `id_parameter_type`=12, `sequence`=14, `name`='Родительский ключ', `sql_type`='INT(8)' WHERE `da_object_parameter_type`.`id_parameter_type`=12");
    $this->execute("UPDATE `da_object_parameter_type` SET `id_parameter_type`=16, `sequence`=15, `name`='Алиас для экземпляра', `sql_type`='VARCHAR(255)' WHERE `da_object_parameter_type`.`id_parameter_type`=16");
    $this->execute("UPDATE `da_object_parameter_type` SET `id_parameter_type`=17, `sequence`=16, `name`='Скрытое поле', `sql_type`='VARCHAR(255)' WHERE `da_object_parameter_type`.`id_parameter_type`=17");
    $this->execute("UPDATE `da_object_parameter_type` SET `id_parameter_type`=13, `sequence`=17, `name`='Последовательность', `sql_type`='INT(8)' WHERE `da_object_parameter_type`.`id_parameter_type`=13");
    $this->execute("UPDATE `da_object_parameter_type` SET `id_parameter_type`=20, `sequence`=20, `name`='Новая дата', `sql_type`='DATETIME' WHERE `da_object_parameter_type`.`id_parameter_type`=20");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
