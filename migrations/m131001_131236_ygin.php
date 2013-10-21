<?php

class m131001_131236_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("INSERT INTO `da_object_parameters` (`id_parameter_type`, `sequence`, `not_null`, `need_locale`, `search`, `is_additional`, `visible`, `id_object`, `group_type`, `caption`, `field_name`, `id_parameter`, `widget`, `add_parameter`, `sql_parameter`, `default_value`, `is_unique`, `hint`) VALUES (13, 0, 0, 0, 0, 0, 1, '101', 0, 'п/п', 'sequence', 'ygin-widget-list-sequence', NULL, NULL, NULL, NULL, 0, '')");
    $this->execute("UPDATE da_object_parameters SET sequence = 291 WHERE id_parameter='ygin-widget-list-sequence'");
    $this->execute("UPDATE `da_site_module_template` SET `sequence`=1 WHERE `da_site_module_template`.`id_module_template`=1");
    $this->execute("UPDATE `da_site_module_template` SET `sequence`=2 WHERE `da_site_module_template`.`id_module_template`=3");
    $this->execute("UPDATE `da_site_module_template` SET `sequence`=3 WHERE `da_site_module_template`.`id_module_template`=4");
    $this->execute("UPDATE `da_site_module_template` SET `sequence`=4 WHERE `da_site_module_template`.`id_module_template`=5");
    $this->execute("UPDATE `da_site_module_template` SET `sequence`=5 WHERE `da_site_module_template`.`id_module_template`=6");
    $this->execute("UPDATE `da_site_module_template` SET `sequence`=6 WHERE `da_site_module_template`.`id_module_template`=2");
    $this->execute("UPDATE `da_site_module_template` SET `sequence`=2 WHERE `da_site_module_template`.`id_module_template`=4");
    $this->execute("UPDATE `da_site_module_template` SET `sequence`=3 WHERE `da_site_module_template`.`id_module_template`=5");
    $this->execute("UPDATE `da_site_module_template` SET `sequence`=4 WHERE `da_site_module_template`.`id_module_template`=6");
    $this->execute("UPDATE `da_site_module_template` SET `sequence`=5 WHERE `da_site_module_template`.`id_module_template`=2");
    $this->execute("UPDATE `da_site_module_template` SET `sequence`=6 WHERE `da_site_module_template`.`id_module_template`=3");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
