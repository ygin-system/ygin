<?php

class m130611_204702_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("TRUNCATE TABLE `da_object_instance`");
    $this->execute("DELETE FROM da_search_data WHERE id_object=66 AND id_instance='48'");
    $this->execute("DELETE FROM `da_object_view_column` WHERE `da_object_view_column`.`id_object_view_column`='48'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=66 AND id_instance='49'");
    $this->execute("DELETE FROM `da_object_view_column` WHERE `da_object_view_column`.`id_object_view_column`='49'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=66 AND id_instance='50'");
    $this->execute("DELETE FROM `da_object_view_column` WHERE `da_object_view_column`.`id_object_view_column`='50'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=63 AND id_instance='24'");
    $this->execute("DELETE FROM `da_object_view` WHERE `da_object_view`.`id_object_view`='24'");
    $this->execute("UPDATE `da_object` SET `id_object`='42', `name`='RSS', `id_field_order`='', `order_type`=1, `table_name`='da_rss', `id_field_caption`='', `object_type`=1, `folder_name`=NULL, `parent_object`=1, `sequence`=13, `use_domain_isolation`=0, `field_caption`=NULL, `yii_model`=NULL WHERE `da_object`.`id_object`='42'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='603'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`='42' AND `da_object_parameters`.`id_parameter`='603'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='604'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`='42' AND `da_object_parameters`.`id_parameter`='604'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='605'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`='42' AND `da_object_parameters`.`id_parameter`='605'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='607'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`='42' AND `da_object_parameters`.`id_parameter`='607'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='608'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`='42' AND `da_object_parameters`.`id_parameter`='608'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='609'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`='42' AND `da_object_parameters`.`id_parameter`='609'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='611'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`='42' AND `da_object_parameters`.`id_parameter`='611'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='612'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`='42' AND `da_object_parameters`.`id_parameter`='612'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='613'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`='42' AND `da_object_parameters`.`id_parameter`='613'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='614'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`='42' AND `da_object_parameters`.`id_parameter`='614'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='615'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`='42' AND `da_object_parameters`.`id_parameter`='615'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='635'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`='42' AND `da_object_parameters`.`id_parameter`='635'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='636'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`='42' AND `da_object_parameters`.`id_parameter`='636'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='637'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`='42' AND `da_object_parameters`.`id_parameter`='637'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='610'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`='42' AND `da_object_parameters`.`id_parameter`='610'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='602'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`='42' AND `da_object_parameters`.`id_parameter`='602'");
    $this->execute("DELETE FROM `da_auth_item` WHERE name='create_object_42'");
    $this->execute("DELETE FROM `da_auth_item` WHERE name='edit_object_42'");
    $this->execute("DELETE FROM `da_auth_item` WHERE name='list_object_42'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=20 AND id_instance='42'");
    $this->execute("DELETE FROM `da_object` WHERE `da_object`.`id_object`='42'");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`='103', `id_parameter`='544', `id_parameter_type`=10, `sequence`=4, `widget`='menu.backend.widgets.phpScript.PhpScriptWidget', `caption`='Обработчик', `field_name`='id_php_script', `add_parameter`='2', `default_value`=NULL, `not_null`=0, `sql_parameter`=NULL, `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='' WHERE `da_object_parameters`.`id_object`='103' AND `da_object_parameters`.`id_parameter`='544'");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`='ygin.menu', `id_parameter`='6', `id_parameter_type`=12, `sequence`=14, `widget`=NULL, `caption`='Смена родительского раздела', `field_name`='id_parent', `add_parameter`='1', `default_value`=NULL, `not_null`=0, `sql_parameter`=NULL, `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=1, `hint`='' WHERE `da_object_parameters`.`id_object`='ygin.menu' AND `da_object_parameters`.`id_parameter`='6'");
    $this->execute("UPDATE `da_object` SET `id_object`='ygin.menu', `name`='Меню', `id_field_order`='', `order_type`=1, `table_name`='da_menu', `id_field_caption`='7', `object_type`=1, `folder_name`='content/menu', `parent_object`=4, `sequence`=1, `use_domain_isolation`=0, `field_caption`='name', `yii_model`='Menu' WHERE `da_object`.`id_object`='ygin.menu'");
    $this->execute("UPDATE `da_object_view` SET `id_object_view`='ygin.menu.view.main', `id_object`='ygin.menu', `name`='Меню', `order_no`=1, `visible`=1, `sql_select`='external_link, go_to_type, alias, id_parent, content', `sql_from`=NULL, `sql_where`=NULL, `sql_order_by`='sequence ASC', `count_data`=50, `icon_class`='icon-list-alt', `id_parent`='id_parent' WHERE `da_object_view`.`id_object_view`='54'");
    $this->execute("UPDATE `da_object_view_column` SET `id_object_view`='ygin.menu.view.main' WHERE id_object_view='54'");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
