<?php

class m120809_134126_ngin extends CDbMigration {
  public function up() {
    $this->execute("

INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('411', '2', 'Иерархия по полю', '63', '0', 'id_parent', 'id_parent', NULL, NULL, NULL, '0', '0', '0', '0', '0', '0', 'Родительское поле для построения иерархии данных');
ALTER TABLE `da_object_view` ADD `id_parent` VARCHAR(255) ;

UPDATE da_object_view v SET v.id_parent = (SELECT p.field_name FROM da_object_parameters p WHERE p.id_object=v.id_object AND p.id_parameter_type=12);

INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('207', '2', 'Свойство модели для отображения', '20', '0', 'caption_field', 'caption_field', NULL, NULL, NULL, '0', '0', '0', '0', '0', '0', 'Используется для отображения названия экземпляра в списках и других местах.\r\nНапример, для отображения имени раздела можно указать name\r\nВ этом случае будет выполнено такое выражение: \$model->name;\r\nТ.о. можно указывать любые доступные атрибуты объекта модели.');
ALTER TABLE `da_object` ADD `caption_field` VARCHAR(255) ;


UPDATE da_object_parameters SET sequence = '1' WHERE id_parameter=63;
UPDATE da_object_parameters SET sequence = '2' WHERE id_parameter=104;
UPDATE da_object_parameters SET sequence = '3' WHERE id_parameter=70;
UPDATE da_object_parameters SET sequence = '4' WHERE id_parameter=64;
UPDATE da_object_parameters SET sequence = '5' WHERE id_parameter=69;
UPDATE da_object_parameters SET sequence = '6' WHERE id_parameter=67;
UPDATE da_object_parameters SET sequence = '7' WHERE id_parameter=155;
UPDATE da_object_parameters SET sequence = '8' WHERE id_parameter=207;
UPDATE da_object_parameters SET sequence = '9' WHERE id_parameter=68;
UPDATE da_object_parameters SET sequence = '10' WHERE id_parameter=65;
UPDATE da_object_parameters SET sequence = '11' WHERE id_parameter=66;
UPDATE da_object_parameters SET sequence = '12' WHERE id_parameter=71;
UPDATE da_object_parameters SET sequence = '13' WHERE id_parameter=124;
UPDATE da_object_parameters SET sequence = '14' WHERE id_parameter=126;
UPDATE da_object_parameters SET sequence = '15' WHERE id_parameter=62;
UPDATE da_object_parameters SET sequence = '16' WHERE id_parameter=61;
UPDATE da_object_parameters SET sequence = '17' WHERE id_parameter=60;
UPDATE da_object_parameters SET sequence = '18' WHERE id_parameter=151;

ALTER TABLE `da_object` CHANGE `caption_field` `field_caption` VARCHAR(255) ;
UPDATE da_object_parameters SET id_parameter_type = '2', caption = 'Свойство модели для отображения', id_object = '20', sequence = '8', name = 'field_caption', field_name = 'field_caption', add_parameter = NULL, sql_parameter = NULL, default_value = NULL, not_null = '0', need_locale = '0', search = '0', is_unique = '0', group_type = '0', is_additional = '0', hint = 'Используется для отображения названия экземпляра в списках и других местах.\r\nНапример, для отображения имени раздела можно указать name\r\nВ этом случае будет выполнено такое выражение: \$model->name;\r\nТ.о. можно указывать любые доступные атрибуты объекта модели.' WHERE id_parameter=207;

UPDATE da_object o SET o.field_caption = (SELECT p.field_name FROM da_object_parameters p WHERE p.id_object=o.id_object AND p.id_parameter=o.id_field_caption);

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
