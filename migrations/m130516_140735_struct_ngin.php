<?php

class m130516_140735_struct_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("ALTER TABLE `da_ajax` DROP `param_value`");
    $this->execute("ALTER TABLE `da_ajax` DROP `param_name`");
    $this->execute("ALTER TABLE `da_ajax` DROP `type_instance`");
    $this->execute("ALTER TABLE `da_ajax` DROP `locate_type`");
    $this->execute("ALTER TABLE `da_ajax` DROP `path`");
    $this->execute("ALTER TABLE `da_ajax` DROP `function_name`");
    $this->execute("ALTER TABLE `da_ajax` DROP `id_ajax`");
    $this->execute("DROP TABLE `da_ajax`");
    $this->execute("DROP TABLE  `da_antispam`");
    $this->execute("ALTER TABLE `da_file_upload_settings` DROP `sizeLimit`");
    $this->execute("ALTER TABLE `da_file_upload_settings` DROP `minSizeLimit`");
    $this->execute("ALTER TABLE `da_file_upload_settings` DROP `id_file_type`");
    $this->execute("ALTER TABLE `da_file_upload_settings` DROP `countFiles`");
    $this->execute("ALTER TABLE `da_file_upload_settings` DROP `id_add_object`");
    $this->execute("ALTER TABLE `da_file_upload_settings` DROP `id_parameter`");
    $this->execute("ALTER TABLE `da_file_upload_settings` DROP `id_object`");
    $this->execute("DROP TABLE `da_file_upload_settings`");
    $this->execute("ALTER TABLE `da_module` DROP `id_child_parent_object`");
    $this->execute("ALTER TABLE `da_module` DROP `id_module_parent`");
    $this->execute("ALTER TABLE `da_module` DROP `id_module_handler`");
    $this->execute("ALTER TABLE `da_module` DROP `id_object`");
    $this->execute("ALTER TABLE `da_module` DROP `name`");
    $this->execute("DROP TABLE `da_module`");
    $this->execute("DROP TABLE `da_cache_data`, `da_cache_setting_script`, `da_cache_url_block`, `da_domain_module`, `da_module_view`, `da_php_script_type_obj_rel`, `da_property`, `da_property_value`, `da_sequence`, `da_session`, `da_session_parameter`");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
