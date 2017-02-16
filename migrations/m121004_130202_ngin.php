<?php

class m121004_130202_ngin extends CDbMigration {
  public function up() {

    $this->execute("UPDATE da_object_parameters SET caption='yii-модель', hint='Например: ngin.models.File или просто Domain, если есть точная уверенность, что система уже знает о моделе' WHERE id_parameter=157");
    $this->execute("UPDATE da_object_view SET icon_class = 'icon-list-alt', id_object = '100', name = 'Меню', order_no = '1', visible = '1', sql_select = 'external_link, go_to_type, alias, idParent, content', sql_from = NULL, sql_where = NULL, sql_order_by = 'sequence ASC', count_data = '50', id_parent = 'idParent' WHERE id_object_view=54");
    $this->execute("UPDATE da_php_script_type SET id_php_script_interface = '6', file_path = 'yiigin.clumn.abstract.SystemModuleFunctionality', class_name = 'SystemModuleFunctionality', description = 'Связь' WHERE id_php_script_type=2");
    $this->execute("UPDATE da_php_script_type SET id_php_script_interface = '6', file_path = 'menu.yiigin.components.column.InfoStatus', class_name = 'InfoStatus', description = 'Статус раздела в объекте Меню' WHERE id_php_script_type=3");
    $this->execute("UPDATE da_php_script_type SET id_php_script_interface = '6', file_path = 'menu.yiigin.column.InfoStatus', class_name = 'InfoStatus', description = 'Статус раздела в объекте Меню' WHERE id_php_script_type=3");
    $this->execute("UPDATE da_php_script_type SET id_php_script_interface = '6', file_path = 'yiigin.components.column.abstract.SystemModuleFunctionality', class_name = 'SystemModuleFunctionality', description = 'Связь' WHERE id_php_script_type=2");
    $this->execute("UPDATE da_php_script_type SET id_php_script_interface = '6', file_path = 'menu.yiigin.column.SiteModuleInfoStatus', class_name = 'SiteModuleInfoStatus', description = 'Статус модуля сайта' WHERE id_php_script_type=4");
    $this->execute("UPDATE da_php_script_type SET id_php_script_interface = '6', file_path = 'photogallery.yiigin.column.PhotoColumn', class_name = 'PhotoColumn', description = 'Фотогалерея » Колонка представления' WHERE id_php_script_type=1001");
    $this->execute("UPDATE da_php_script_type SET id_php_script_interface = '13', file_path = 'project/plugin/photogallery/PhotogalleryPhoto.php', class_name = 'PhotogalleryPhoto', description = 'PhotogalleryPhoto' WHERE id_php_script_type=1017");
    $this->execute("UPDATE da_object_view_column SET id_object_view = '2002', id_object = '502', caption = 'Комменты', visible = '0', order_no = '10', id_object_parameter = NULL, id_data_type = '10', field_name = '-', handler = '250' WHERE id_object_view_column=6027");

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
