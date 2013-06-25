<?php

class m120728_223710_ngin extends CDbMigration {
  public function up() {
    $this->execute("

INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('410', '2', 'css-класс иконки', '63', '0', 'icon_class', 'icon_class', NULL, NULL, NULL, '0', '0', '0', '0', '0', '0', 'Css-класс иконки из Twitter Bootstrap, который будет отображаться в меню');
ALTER TABLE `da_object_view` ADD `icon_class` VARCHAR(255) ;

UPDATE da_object_view SET id_object = '100', name = 'Меню', order_no = '1', visible = '1', sql_select = NULL, sql_from = NULL, sql_where = NULL, sql_order_by = 'sequence ASC', count_data = '50', icon_class = 'icon-th-list' WHERE id_object_view=54;

UPDATE da_object_view SET id_object = '100', name = 'Меню', order_no = '1', visible = '1', sql_select = NULL, sql_from = NULL, sql_where = NULL, sql_order_by = 'sequence ASC', count_data = '50', icon_class = 'icon-list-alt' WHERE id_object_view=54;

UPDATE da_object_view SET id_object = '502', name = 'Новости', order_no = '1', visible = '1', sql_select = NULL, sql_from = NULL, sql_where = NULL, sql_order_by = 'date DESC', count_data = '50', icon_class = 'icon-bullhorn' WHERE id_object_view=2002;

UPDATE da_object_view SET id_object = '500', name = 'Фотогалереи', order_no = '1', visible = '1', sql_select = NULL, sql_from = NULL, sql_where = NULL, sql_order_by = 'id_photogallery ASC', count_data = '50', icon_class = 'icon-picture' WHERE id_object_view=2000;

UPDATE da_object_view SET id_object = '517', name = 'Обратная связь', order_no = '1', visible = '1', sql_select = NULL, sql_from = NULL, sql_where = NULL, sql_order_by = 'id_feedback DESC', count_data = '50', icon_class = 'icon-share-alt' WHERE id_object_view=2016;

UPDATE da_object_view SET id_object = '512', name = 'Вопрос-ответ', order_no = '1', visible = '1', sql_select = NULL, sql_from = NULL, sql_where = NULL, sql_order_by = 'ask_date DESC', count_data = '50', icon_class = 'icon-retweet' WHERE id_object_view=2011;

UPDATE da_object_view SET id_object = '250', name = 'Комментарии', order_no = '1', visible = '1', sql_select = NULL, sql_from = NULL, sql_where = NULL, sql_order_by = 'comment_date ASC', count_data = '50', icon_class = 'icon-comment' WHERE id_object_view=67;

UPDATE da_object_view SET id_object = '20', name = 'Объекты', order_no = '1', visible = '1', sql_select = NULL, sql_from = NULL, sql_where = NULL, sql_order_by = 'sequence ASC', count_data = '50', icon_class = 'icon-th-large' WHERE id_object_view=2;

UPDATE da_object_view SET id_object = '24', name = 'Пользователи', order_no = '1', visible = '1', sql_select = NULL, sql_from = NULL, sql_where = NULL, sql_order_by = NULL, count_data = '50', icon_class = 'icon-user' WHERE id_object_view=6;

UPDATE da_object_view SET id_object = '34', name = 'Подписчики на события', order_no = '1', visible = '1', sql_select = NULL, sql_from = NULL, sql_where = NULL, sql_order_by = NULL, count_data = '50', icon_class = 'icon-envelope' WHERE id_object_view=16;

UPDATE da_object_view SET id_object = '519', name = 'Заказы пользователей', order_no = '1', visible = '1', sql_select = NULL, sql_from = NULL, sql_where = NULL, sql_order_by = 'create_date DESC', count_data = '50', icon_class = 'icon-shopping-cart' WHERE id_object_view=2017;

UPDATE da_object_view SET id_object = '509', name = 'Каталог продукции', order_no = '1', visible = '1', sql_select = NULL, sql_from = NULL, sql_where = NULL, sql_order_by = NULL, count_data = '50', icon_class = 'icon-gift' WHERE id_object_view=2008;

UPDATE da_system_parameter SET value = '2012.07.28' WHERE id_system_parameter=4;

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
