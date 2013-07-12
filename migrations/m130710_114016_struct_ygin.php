<?php

class m130710_114016_struct_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("ALTER TABLE `da_site_module_template` COMMENT='Наборы виджетов'");
    $this->execute("ALTER TABLE `da_site_module` COMMENT='Виджеты сайта'");
    $this->execute("ALTER TABLE `da_site_module_template` CHANGE `is_default_template` `is_default_template` TINYINT(1) NOT NULL default '0' COMMENT  'Использовать по умолчанию'");
    $this->execute("ALTER TABLE `da_menu` CHANGE `removable` `removable` TINYINT(1) NOT NULL default '1' COMMENT  'Разрешить удаление'");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
