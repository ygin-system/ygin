<?php

class m140224_111616_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("INSERT INTO `da_object_parameters` (`id_parameter_type`, `sequence`, `not_null`, `need_locale`, `search`, `is_additional`, `visible`, `id_object`, `group_type`, `caption`, `field_name`, `id_parameter`, `widget`, `add_parameter`, `sql_parameter`, `default_value`, `is_unique`, `hint`) VALUES (14, 0, 0, 0, 0, 0, 1, '63', 0, 'Описание представления', 'description', 'ygin-object-view-description', NULL, NULL, NULL, NULL, 0, 'Данное описание будет выводится в списке экземпляров сразу после заголовка представления. Служит для подробного описания назначения объекта и представления.')");
    $this->execute("UPDATE da_object_parameters SET sequence = 292 WHERE id_parameter='ygin-object-view-description'");
    $this->execute("UPDATE `da_object_view` SET `id_object_view`='43', `id_object`='63', `name`='Представление', `order_no`=1, `visible`=0, `sql_select`=NULL, `sql_from`=NULL, `sql_where`=NULL, `sql_order_by`='order_no ASC', `count_data`=50, `icon_class`=NULL, `id_parent`=NULL, `description`='<p>Для получения возможности редактирования экземпляров объекта (осуществления CRUD-операций) необходимо создать представление. Один объект может иметь множество представлений. Представление хранит информацию о свойствах объекта, отображаемых в списке экземпляров, а также о порядке их сортировки.</p>  <p>Быстро создать представление для объекта и его колонки можно при редактировании объекта в блоке Создать представление. Подробнее читай в <a target=\"_blank\" href=\"http://www.ygin.ru/documentation/sozdanie-predstavlenii-obekta-17/\">документации</a> к системе.</p>' WHERE `da_object_view`.`id_object_view`='43'");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
