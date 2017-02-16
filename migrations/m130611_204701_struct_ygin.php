<?php

class m130611_204701_struct_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("DROP TABLE `da_domain_object`");
    $this->execute("DROP TABLE `da_permission_type`");
    $this->execute("DROP TABLE `da_rss`");
    $this->execute("ALTER TABLE `da_site_module` CHANGE `link` `id_php_script` INT( 8 ) NULL DEFAULT NULL COMMENT 'Обработчик'");
    $this->execute("DROP TABLE `da_user_settings`");
    $this->execute("ALTER TABLE `da_menu` CHANGE `idParent` `id_parent` INT(8) COMMENT  'Смена родительского раздела'");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
