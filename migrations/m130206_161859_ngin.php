<?php

class m130206_161859_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE `da_object_parameters` SET `id_object`=100, `id_parameter`=549, `id_parameter_type`=10, `sequence`=6, `name`='menu.yiigin.widgets.externalLink.ExternalLinkWidget', `caption`='Ссылка на страницу', `field_name`='-', `add_parameter`=2, `default_value`=NULL, `not_null`=0, `sql_parameter`='MenuHref', `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=1, `hint`='При отображении в меню раздел будет иметь указанную ссылку. Используется для создания внешних ссылок в меню или прямых ссылок на файл (например, прайс).' WHERE `da_object_parameters`.`id_object`=100 AND `da_object_parameters`.`id_parameter`=549");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false, false, false);
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
