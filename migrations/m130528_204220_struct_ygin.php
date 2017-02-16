<?php

class m130528_204220_struct_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("ALTER TABLE  `da_object` CHANGE  `id_object`  `id_object` VARCHAR( 255 ) NOT NULL COMMENT  'id'");
    $this->execute("ALTER TABLE  `da_object_parameters` CHANGE  `id_object`  `id_object` VARCHAR( 255 ) NOT NULL DEFAULT  '0' COMMENT  'Объект',
CHANGE  `add_parameter`  `add_parameter` VARCHAR( 255 ) NULL DEFAULT NULL COMMENT  'Параметр'");
    $this->execute("ALTER TABLE  `da_object_view` CHANGE  `id_object`  `id_object` VARCHAR( 255 ) NOT NULL COMMENT  'Объект'");
    $this->execute("ALTER TABLE  `da_object_view_column` CHANGE  `id_object`  `id_object` VARCHAR( 255 ) NOT NULL COMMENT  'Объект'");
    $this->execute("ALTER TABLE  `da_files` CHANGE  `id_object`  `id_object` VARCHAR( 255 ) NULL DEFAULT NULL COMMENT  'Объект'");
    $this->execute("ALTER TABLE  `da_object_parameters` CHANGE  `id_parameter`  `id_parameter` VARCHAR( 255 ) NOT NULL COMMENT  'ИД'");
    $this->execute("ALTER TABLE  `da_object` CHANGE  `id_field_order`  `id_field_order` VARCHAR( 255 ) NULL DEFAULT NULL COMMENT  'Свойство для порядка'");
    $this->execute("ALTER TABLE  `da_object` CHANGE  `id_field_caption`  `id_field_caption` VARCHAR( 255 ) NULL DEFAULT NULL COMMENT  'Свойство для отображения'");
    $this->execute("ALTER TABLE  `da_files` CHANGE  `id_parameter`  `id_parameter` VARCHAR( 255 ) NULL DEFAULT NULL COMMENT  'Свойство объекта'");
    $this->execute("ALTER TABLE  `da_object_view_column` CHANGE  `id_object_parameter`  `id_object_parameter` VARCHAR( 255 ) NULL DEFAULT NULL COMMENT  'Параметр объекта'");
    $this->execute("ALTER TABLE  `da_object_view` CHANGE  `id_object_view`  `id_object_view` VARCHAR( 255 ) NOT NULL COMMENT  'id'");
    $this->execute("ALTER TABLE  `da_object_view_column` CHANGE  `id_object_view`  `id_object_view` VARCHAR( 255 ) NOT NULL COMMENT  'Представление'");
    $this->execute("ALTER TABLE  `da_object_view_column` CHANGE  `id_object_view_column`  `id_object_view_column` VARCHAR( 255 ) NOT NULL COMMENT  'id'");
    $this->execute("ALTER TABLE `da_job_parameter_value` DROP `id_job_parameter`");
    $this->execute("ALTER TABLE `da_job_parameter_value` DROP `name`");
    $this->execute("ALTER TABLE `da_job_parameter_value` DROP `value`");
    $this->execute("DROP TABLE `da_job_parameter_value`");
    $this->execute("ALTER TABLE  `da_job` CHANGE  `id_job`  `id_job` VARCHAR( 255 ) NOT NULL COMMENT  'ИД задачи'");
    $this->execute("ALTER TABLE  `da_job` CHANGE  `name`  `name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  'Имя задачи'");
    $this->execute("ALTER TABLE  `da_php_script_type` CHANGE  `id_php_script_type`  `id_php_script_type` VARCHAR( 255 ) NOT NULL COMMENT  'id'");
    $this->execute("ALTER TABLE  `da_php_script` CHANGE  `id_php_script_type`  `id_php_script_type` VARCHAR( 255 ) NOT NULL");
    $this->execute("ALTER TABLE  `da_object_view_column` CHANGE  `handler`  `handler` VARCHAR( 255 ) NULL DEFAULT NULL COMMENT  'Обработчик'");
    $this->execute("ALTER TABLE  `da_system_parameter` CHANGE  `id_system_parameter`  `id_system_parameter` VARCHAR( 255 ) NOT NULL COMMENT  'id'");
    $this->execute("ALTER TABLE  `da_references` CHANGE  `id_reference`  `id_reference` VARCHAR( 255 ) NOT NULL COMMENT  'id'");
    $this->execute("ALTER TABLE  `da_reference_element` CHANGE  `id_reference`  `id_reference` VARCHAR( 255 ) NOT NULL DEFAULT  '0' COMMENT  'Справочник'");
    $this->execute("ALTER TABLE  `da_reference_element` CHANGE  `id_reference_element_instance`  `id_reference_element_instance` VARCHAR( 255 ) NOT NULL COMMENT  'id'");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
