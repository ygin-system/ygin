<?php

class m130718_213659_struct_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("ALTER TABLE `da_event_type` CHANGE `id_object` `id_object` VARCHAR( 255 ) NULL DEFAULT NULL COMMENT 'Объект для работы'");
    $this->execute("ALTER TABLE `pr_comment` CHANGE `id_object` `id_object` VARCHAR( 255 ) NOT NULL COMMENT 'Объект'");
    $this->execute("ALTER TABLE `pr_banner_place` CHANGE `id_object` `id_object` VARCHAR( 255 ) NULL DEFAULT NULL COMMENT 'id_object'");
    $this->execute("ALTER TABLE `pr_photogallery_photo` CHANGE `id_photogallery_object` `id_photogallery_object` VARCHAR( 255 ) NOT NULL COMMENT 'Объект'");
    $this->execute("ALTER TABLE `da_visit_site` CHANGE `id_object` `id_object` VARCHAR( 255 ) NOT NULL DEFAULT '0'");
    $this->execute("ALTER TABLE `da_stat_view` CHANGE `id_object` `id_object` VARCHAR( 255 ) NOT NULL");
    $this->execute("ALTER TABLE `da_object_instance` CHANGE `id_object` `id_object` VARCHAR( 255 ) NOT NULL");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
