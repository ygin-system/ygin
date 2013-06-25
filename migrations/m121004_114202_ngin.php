<?php

class m121004_114202_ngin extends CDbMigration {
  public function up() {

    $this->execute("UPDATE da_object_view_column SET visible = '0' WHERE id_object_view_column=149");
    $this->execute("INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('157', '2', 'yiii-модель', '20', '0', 'yii_model', 'yii_model', NULL, NULL, NULL, '0', '0', '0', '0', '0', '0', 'Например: ngin.models.File или просто Domain, если есть точная уверенность, что система уже знает о моделе')");
    $this->execute("ALTER TABLE `da_object` ADD `yii_model` VARCHAR(255)");
    $this->execute("UPDATE da_object SET yii_model = 'Menu' WHERE id_object=100");
    $this->execute("UPDATE da_object_view_column SET id_object_view = '54', id_object = '100', caption = NULL, visible = '1', order_no = '2', id_object_parameter = '5', id_data_type = '10', field_name = 'visible', handler = '3' WHERE id_object_view_column=116");
    $this->execute("UPDATE da_object_view SET icon_class = 'icon-list-alt', id_object = '100', name = 'Меню', order_no = '1', visible = '1', sql_select = 'external_link, go_to_type, alias, idParent, content', sql_from = NULL, sql_where = NULL, sql_order_by = 'sequence ASC', count_data = '50', id_parent = 'idParent' WHERE id_object_view=54");
    $this->execute("UPDATE da_php_script_type SET id_php_script_interface = '6', file_path = 'yiigin.clumn.abstract.SystemModuleFunctionality', class_name = 'SystemModuleFunctionality', description = 'Связь' WHERE id_php_script_type=2");
    $this->execute("UPDATE da_php_script_type SET id_php_script_interface = '6', file_path = 'menu.yiigin.components.column.InfoStatus', class_name = 'InfoStatus', description = 'Статус раздела в объекте Меню' WHERE id_php_script_type=3");
    $this->execute("UPDATE da_php_script_type SET id_php_script_interface = '6', file_path = 'menu.yiigin.column.InfoStatus', class_name = 'InfoStatus', description = 'Статус раздела в объекте Меню' WHERE id_php_script_type=3");
    $this->execute("UPDATE da_php_script_type SET id_php_script_interface = '6', file_path = 'yiigin.components.column.abstract.SystemModuleFunctionality', class_name = 'SystemModuleFunctionality', description = 'Связь' WHERE id_php_script_type=2");
    $this->execute("UPDATE da_php_script_type SET id_php_script_interface = '6', file_path = 'menu.yiigin.column.SiteModuleInfoStatus', class_name = 'SiteModuleInfoStatus', description = 'Статус модуля сайта' WHERE id_php_script_type=4");
    $this->execute("UPDATE da_object SET yii_model = 'SiteModule' WHERE id_object=103");
    $this->execute("UPDATE da_object_view_column SET id_object_view = '57', id_object = '103', caption = NULL, visible = '0', order_no = '3', id_object_parameter = NULL, id_data_type = '10', field_name = 'cache', handler = '5' WHERE id_object_view_column=150");
    $this->execute("UPDATE da_php_script_type SET id_php_script_interface = '6', file_path = 'photogallery.yiigin.column.PhotoColumn', class_name = 'PhotoColumn', description = 'Фотогалерея » Колонка представления' WHERE id_php_script_type=1001");
    $this->execute("UPDATE da_php_script_type SET id_php_script_interface = '13', file_path = 'project/plugin/photogallery/PhotogalleryPhoto.php', class_name = 'PhotogalleryPhoto', description = 'PhotogalleryPhoto' WHERE id_php_script_type=1017");
    $this->execute("UPDATE da_object_view_column SET id_object_view = '2002', id_object = '502', caption = 'Комменты', visible = '0', order_no = '10', id_object_parameter = NULL, id_data_type = '10', field_name = '-', handler = '250' WHERE id_object_view_column=6027");
    $this->execute("UPDATE da_object_parameters SET sequence = '1' WHERE id_parameter=63");
    $this->execute("UPDATE da_object_parameters SET sequence = '2' WHERE id_parameter=104");
    $this->execute("UPDATE da_object_parameters SET sequence = '3' WHERE id_parameter=70");
    $this->execute("UPDATE da_object_parameters SET sequence = '4' WHERE id_parameter=64");
    $this->execute("UPDATE da_object_parameters SET sequence = '5' WHERE id_parameter=69");
    $this->execute("UPDATE da_object_parameters SET sequence = '6' WHERE id_parameter=67");
    $this->execute("UPDATE da_object_parameters SET sequence = '7' WHERE id_parameter=155");
    $this->execute("UPDATE da_object_parameters SET sequence = '8' WHERE id_parameter=207");
    $this->execute("UPDATE da_object_parameters SET sequence = '9' WHERE id_parameter=68");
    $this->execute("UPDATE da_object_parameters SET sequence = '10' WHERE id_parameter=65");
    $this->execute("UPDATE da_object_parameters SET sequence = '11' WHERE id_parameter=66");
    $this->execute("UPDATE da_object_parameters SET sequence = '12' WHERE id_parameter=71");
    $this->execute("UPDATE da_object_parameters SET sequence = '13' WHERE id_parameter=124");
    $this->execute("UPDATE da_object_parameters SET sequence = '14' WHERE id_parameter=126");
    $this->execute("UPDATE da_object_parameters SET sequence = '15' WHERE id_parameter=62");
    $this->execute("UPDATE da_object_parameters SET sequence = '16' WHERE id_parameter=157");
    $this->execute("UPDATE da_object_parameters SET sequence = '17' WHERE id_parameter=61");
    $this->execute("UPDATE da_object_parameters SET sequence = '18' WHERE id_parameter=60");
    $this->execute("UPDATE da_object_parameters SET sequence = '19' WHERE id_parameter=151");

    $path = Yii::getPathOfAlias("webroot.assets");
    HFile::removeDirectoryRecursive($path, false);
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
