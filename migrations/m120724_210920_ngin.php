<?php

class m120724_210920_ngin extends CDbMigration {
  public function up() {
    $this->execute("

INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('11', '8', 'Картинка для раздела', '100', '0', 'image', 'image', '1', NULL, NULL, '0', '0', '0', '0', '0', '1', NULL);
ALTER TABLE `da_menu` ADD `image` INT(8) ;

UPDATE da_object_parameters SET sequence = '1' WHERE id_parameter=1;
UPDATE da_object_parameters SET sequence = '2' WHERE id_parameter=2;
UPDATE da_object_parameters SET sequence = '3' WHERE id_parameter=127;
UPDATE da_object_parameters SET sequence = '4' WHERE id_parameter=3;
UPDATE da_object_parameters SET sequence = '5' WHERE id_parameter=5;
UPDATE da_object_parameters SET sequence = '6' WHERE id_parameter=549;
UPDATE da_object_parameters SET sequence = '7' WHERE id_parameter=229;
UPDATE da_object_parameters SET sequence = '8' WHERE id_parameter=4;
UPDATE da_object_parameters SET sequence = '9' WHERE id_parameter=8;
UPDATE da_object_parameters SET sequence = '10' WHERE id_parameter=9;
UPDATE da_object_parameters SET sequence = '11' WHERE id_parameter=7;
UPDATE da_object_parameters SET sequence = '12' WHERE id_parameter=10;
UPDATE da_object_parameters SET sequence = '13' WHERE id_parameter=15;
UPDATE da_object_parameters SET sequence = '14' WHERE id_parameter=6;
UPDATE da_object_parameters SET sequence = '15' WHERE id_parameter=599;
UPDATE da_object_parameters SET sequence = '16' WHERE id_parameter=152;
UPDATE da_object_parameters SET sequence = '17' WHERE id_parameter=154;
UPDATE da_object_parameters SET sequence = '18' WHERE id_parameter=153;
UPDATE da_object_parameters SET sequence = '19' WHERE id_parameter=547;
UPDATE da_object_parameters SET sequence = '20' WHERE id_parameter=548;
UPDATE da_object_parameters SET sequence = '21' WHERE id_parameter=330;
UPDATE da_object_parameters SET sequence = '22' WHERE id_parameter=11;



INSERT INTO da_php_script_type (id_php_script_type, id_php_script_interface, file_path, class_name, description) VALUES ('1042', '2', 'menu.widgets.DaMenuWidget', 'DaMenuWidget', 'Меню');
INSERT INTO da_module (id_module, name) VALUES ('1014', 'Меню');
INSERT INTO da_module_view(id_module, id_php_script_type) VALUES(1014, 1042);
INSERT INTO da_domain_module(id_domain, id_module) VALUES(1, 1014);

INSERT INTO da_php_script_type_parameter (id_php_script_parameter, id_php_script_type, parameter_name, caption, default_value) VALUES ('1020', '1042', 'rootItem', 'ИД корневого раздела', NULL);

INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('352', '9', 'Исполняемое выражение', '81', '0', 'eval', 'eval', NULL, NULL, NULL, '0', '0', '0', '0', '0', '0', 'При включенном признаке, значение будет исполнено (eval(value)) и возвращено в качестве значения параметра.');
ALTER TABLE `da_php_script_type_parameter` ADD `eval` TINYINT(1) ;

UPDATE da_object_parameters SET sequence = '1' WHERE id_parameter=343;
UPDATE da_object_parameters SET sequence = '2' WHERE id_parameter=344;
UPDATE da_object_parameters SET sequence = '3' WHERE id_parameter=345;
UPDATE da_object_parameters SET sequence = '4' WHERE id_parameter=346;
UPDATE da_object_parameters SET sequence = '5' WHERE id_parameter=349;
UPDATE da_object_parameters SET sequence = '6' WHERE id_parameter=352;


INSERT INTO da_php_script_type_parameter (id_php_script_parameter, id_php_script_type, parameter_name, caption, default_value, eval) VALUES ('1021', '1042', 'htmlOptions', 'Атрибуты корневого ul (исполняемое выражение)', 'array()', '1');

INSERT INTO da_php_script_type_parameter (id_php_script_parameter, id_php_script_type, parameter_name, caption, default_value, eval) VALUES ('1022', '1042', 'activeCssClass', 'css-класс для активного элемента', NULL, '0');

INSERT INTO da_php_script_type_parameter (id_php_script_parameter, id_php_script_type, parameter_name, caption, default_value, eval) VALUES ('1023', '1042', 'itemCssClass', 'css-класс элементов', NULL, '0');

INSERT INTO da_php_script_type_parameter (id_php_script_parameter, id_php_script_type, parameter_name, caption, default_value, eval) VALUES ('1024', '1042', 'encodeLabel', 'Кодировать лли подпись', 'false', '1');

INSERT INTO da_php_script_type_parameter (id_php_script_parameter, id_php_script_type, parameter_name, caption, default_value, eval) VALUES ('1025', '1042', 'submenuHtmlOptions', 'Атрибуты для ul кроме корневого (исполняемое выражение)', 'array()', '1');

INSERT INTO da_php_script_type_parameter (id_php_script_parameter, id_php_script_type, parameter_name, caption, default_value, eval) VALUES ('1026', '1042', 'maxChildLevel', 'Кол-во выводимых уровней (-1 - все, 0-первый и т.д.)', '1', '0');

INSERT INTO da_php_script_type_parameter (id_php_script_parameter, id_php_script_type, parameter_name, caption, default_value, eval) VALUES ('1027', '1042', 'baseTemplate', 'Шаблон для оборачивания всего меню (доступна переменная {menu})', NULL, '0');

UPDATE da_php_script_type_parameter SET id_php_script_type = '1042', parameter_name = 'encodeLabel', caption = 'Кодировать ли подпись (исполняемое выражение)', default_value = 'false', eval = '1' WHERE id_php_script_parameter=1024;

UPDATE da_php_script_type_parameter SET id_php_script_type = '1042', parameter_name = 'rootItem', caption = 'ИД корневого раздела (пусто - все разделы первого уровня)', default_value = NULL, eval = '0' WHERE id_php_script_parameter=1020;

INSERT INTO da_php_script (id_php_script, id_php_script_type, id_module) VALUES (1023, 1042, 1014);
DELETE FROM da_php_script_parameter WHERE id_php_script=1023;
INSERT INTO da_php_script_parameter (id_php_script, id_php_script_type, id_php_script_parameter, param_value) VALUES (1023, 1042, 1021, 'array(\'class\' => \'nav nav-list\')');
INSERT INTO da_php_script_parameter (id_php_script, id_php_script_type, id_php_script_parameter, param_value) VALUES (1023, 1042, 1022, 'active');
INSERT INTO da_php_script_parameter (id_php_script, id_php_script_type, id_php_script_parameter, param_value) VALUES (1023, 1042, 1023, 'item');
INSERT INTO da_php_script_parameter (id_php_script, id_php_script_type, id_php_script_parameter, param_value) VALUES (1023, 1042, 1024, 'false');
INSERT INTO da_php_script_parameter (id_php_script, id_php_script_type, id_php_script_parameter, param_value) VALUES (1023, 1042, 1025, 'array(\'class\' => \'nav nav-list sub-item-list\')');
INSERT INTO da_php_script_parameter (id_php_script, id_php_script_type, id_php_script_parameter, param_value) VALUES (1023, 1042, 1026, '2');
INSERT INTO da_php_script_parameter (id_php_script, id_php_script_type, id_php_script_parameter, param_value) VALUES (1023, 1042, 1027, '<div class=\"b-menu-side-list\">{menu}</div>');
INSERT INTO da_site_module (id_module, name, is_visible, content, html, directory, link) VALUES ('119', 'Левое меню', '1', NULL, NULL, NULL, '1023');

UPDATE da_site_module_template SET name = 'Главная', is_default_template = '0' WHERE id_module_template=4;
DELETE FROM da_site_module_rel WHERE id_module_template=4;
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (112, 4, 4, 1);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (114, 4, 1, 3);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (117, 4, 6, 1);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (119, 4, 1, 2);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (100, 4, 1, 1);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (113, 4, 4, 2);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (118, 4, 6, 2);

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
