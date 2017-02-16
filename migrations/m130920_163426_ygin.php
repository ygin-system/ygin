<?php

class m130920_163426_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("INSERT INTO `da_references` (`id_reference`, `name`) VALUES ('ygin-comment-reference-status', 'Статусы комментария')");
    $this->execute("INSERT INTO `da_reference_element` (`id_reference`, `id_reference_element`, `id_reference_element_instance`, `value`, `image_element`) VALUES ('ygin-comment-reference-status', 1, 'ygin-comment-reference-status-approved', 'Отмодерирован', NULL)");
    $this->execute("INSERT INTO `da_reference_element` (`id_reference`, `id_reference_element`, `id_reference_element_instance`, `value`, `image_element`) VALUES ('ygin-comment-reference-status', 2, 'ygin-comment-reference-status-pending', 'Ожидает модерации', NULL)");
    $this->execute("INSERT INTO `da_reference_element` (`id_reference`, `id_reference_element`, `id_reference_element_instance`, `value`, `image_element`) VALUES ('ygin-comment-reference-status', 3, 'ygin-comment-reference-status-deleted', 'Удален', NULL)");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`='250', `id_parameter`='1208', `id_parameter_type`=6, `sequence`=8, `widget`=NULL, `caption`='Отмодерировано', `field_name`='moderation', `add_parameter`='ygin-comment-reference-status', `default_value`=NULL, `not_null`=1, `sql_parameter`=NULL, `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='', `visible`=1 WHERE `da_object_parameters`.`id_object`='250' AND `da_object_parameters`.`id_parameter`='1208'");
    $this->execute("UPDATE `da_object_view_column` SET `id_object_view_column`='147', `id_object_view`='67', `id_object`='250', `caption`='Статус', `order_no`=3, `id_object_parameter`='1208', `id_data_type`=6, `field_name`='moderation', `handler`='', `visible`=1 WHERE `da_object_view_column`.`id_object_view_column`='147'");
    $this->execute("UPDATE `da_object_view_column` SET `order_no`=3 WHERE `da_object_view_column`.`id_object_view_column`='148'");
    $this->execute("UPDATE `da_object_view_column` SET `order_no`=4 WHERE `da_object_view_column`.`id_object_view_column`='6093'");
    $this->execute("UPDATE `da_object_view_column` SET `order_no`=5 WHERE `da_object_view_column`.`id_object_view_column`='147'");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
