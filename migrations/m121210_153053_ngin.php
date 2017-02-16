<?php

class m121210_153053_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE `da_object` SET `id_object`=33, `name`='Формат сообщения', `id_field_order`=250, `order_type`=1, `table_name`='da_event_format', `id_field_caption`=31, `object_type`=1, `folder_name`=NULL, `parent_object`=6, `sequence`=3, `seq_start_value`=100, `use_domain_isolation`=0, `id_object_handler`=NULL, `id_instance_class`=NULL, `field_caption`='description', `yii_model`=NULL WHERE `da_object`.`id_object`=33");
    $this->execute("UPDATE `da_object` SET `id_object_handler`=NULL, `id_instance_class`=NULL WHERE `da_object`.`id_object`=24");
    $this->execute("DELETE FROM `da_php_script_type` WHERE `da_php_script_type`.`id_php_script_type`=447");
    $this->execute("DELETE FROM `da_php_script_type` WHERE `da_php_script_type`.`id_php_script_type`=404");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`=24, `id_parameter`=91, `id_parameter_type`=2, `sequence`=6, `name`='user.yiigin.widgets.userPassword.UserPasswordWidget', `caption`='Пароль', `field_name`='user_password', `add_parameter`=2, `default_value`=NULL, `not_null`=0, `sql_parameter`=NULL, `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`=NULL WHERE `da_object_parameters`.`id_object`=24 AND `da_object_parameters`.`id_parameter`=91");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`=24, `id_parameter`=89, `id_parameter_type`=10, `sequence`=2, `name`='user.yiigin.widgets.roles.RolesWidget', `caption`='Роли пользователя', `field_name`='-', `add_parameter`=2, `default_value`=NULL, `not_null`=1, `sql_parameter`=NULL, `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`=NULL WHERE `da_object_parameters`.`id_object`=24 AND `da_object_parameters`.`id_parameter`=89");
    $this->execute("UPDATE `da_object_view_column` SET `visible`=0 WHERE `da_object_view_column`.`id_object_view_column`=12");
    $this->execute("DELETE FROM da_auth_item WHERE name='guest'");
    $this->execute("UPDATE `da_object_parameters` SET `not_null`=1 WHERE `da_object_parameters`.`id_object`=24 AND `da_object_parameters`.`id_parameter`=92");
    $this->execute("DELETE FROM `da_auth_item_child` WHERE parent='editor' AND child='edit_object_513'");
    $this->execute("DELETE FROM `da_auth_item_child` WHERE parent='editor' AND child='create_object_513'");
    $this->execute("INSERT IGNORE INTO `da_auth_item_child` (`parent`, `child`) VALUES ('dev', 'list_object_513')");
    $this->execute("DELETE FROM `da_auth_item_child` WHERE parent='editor' AND child='list_object_513'");
    $this->execute("DELETE FROM `da_auth_item_child` WHERE parent='editor' AND child='view_object_531'");
    $this->execute("DELETE FROM `da_auth_item_child` WHERE parent='editor' AND child='list_object_531'");
    $this->execute("UPDATE `da_object` SET `yii_model`='ngin.models.SystemParameter' WHERE `da_object`.`id_object`=30");
    $this->execute("INSERT IGNORE INTO `da_auth_item_child` (`parent`, `child`) VALUES ('dev', 'list_object_30')");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false, false, false);
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
