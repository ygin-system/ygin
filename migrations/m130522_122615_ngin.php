<?php

class m130522_122615_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE `da_object_parameters` SET `id_object`=100, `id_parameter`=549, `id_parameter_type`=10, `sequence`=6, `widget`='menu.yiigin.widgets.externalLink.ExternalLinkWidget', `caption`='Ссылка на страницу', `field_name`='external_link', `add_parameter`=2, `default_value`='', `not_null`=0, `sql_parameter`='MenuHref', `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=1, `hint`='При отображении в меню раздел будет иметь указанную ссылку. Используется для создания внешних ссылок в меню или прямых ссылок на файл (например, прайс).' WHERE `da_object_parameters`.`id_object`=100 AND `da_object_parameters`.`id_parameter`=549");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`=100, `id_parameter`=2, `id_parameter_type`=2, `sequence`=2, `widget`='menu.yiigin.widgets.menuName.MenuNameWidget', `caption`='Название в меню', `field_name`='name', `add_parameter`=0, `default_value`='Имя раздела', `not_null`=1, `sql_parameter`='', `is_unique`=0, `group_type`=0, `need_locale`=1, `search`=1, `is_additional`=0, `hint`='Краткое название раздела, отображаемое в меню сайта' WHERE `da_object_parameters`.`id_object`=100 AND `da_object_parameters`.`id_parameter`=2");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`=103, `id_parameter`=544, `id_parameter_type`=10, `sequence`=4, `widget`='menu.yiigin.widgets.phpScript.PhpScriptWidget', `caption`='Обработчик', `field_name`='link', `add_parameter`=2, `default_value`='', `not_null`=0, `sql_parameter`='', `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='' WHERE `da_object_parameters`.`id_object`=103 AND `da_object_parameters`.`id_parameter`=544");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
