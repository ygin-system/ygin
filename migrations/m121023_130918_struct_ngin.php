<?php

class m121023_130918_struct_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("ALTER TABLE `da_object` CHANGE `id_object` `id_object` INT( 3 ) NOT NULL AUTO_INCREMENT");
    $this->execute("ALTER TABLE `pr_photogallery_photo` CHANGE `id_photogallery_photo` `id_photogallery_photo` INT( 8 ) NOT NULL AUTO_INCREMENT");
    $this->execute("ALTER TABLE `da_object_parameters` CHANGE `id_parameter` `id_parameter` INT( 8 ) NOT NULL AUTO_INCREMENT");
    $this->execute("ALTER TABLE `da_job` CHANGE `id_job` `id_job` INT( 8 ) NOT NULL AUTO_INCREMENT");
    $this->execute("ALTER TABLE `da_object_view` CHANGE `id_object_view` `id_object_view` INT( 8 ) NOT NULL AUTO_INCREMENT");
    $this->execute("ALTER TABLE `da_object_view_column` CHANGE `id_object_view_column` `id_object_view_column` INT( 8 ) NOT NULL AUTO_INCREMENT");
    $this->execute("ALTER TABLE `da_php_script_interface` CHANGE `id_php_script_interface` `id_php_script_interface` INT( 8 ) NOT NULL AUTO_INCREMENT");
    $this->execute("ALTER TABLE `da_php_script_type` CHANGE `id_php_script_type` `id_php_script_type` INT( 8 ) NOT NULL AUTO_INCREMENT");
    $this->execute("ALTER TABLE `da_references` CHANGE `id_reference` `id_reference` INT( 8 ) NOT NULL AUTO_INCREMENT");
    $this->execute("ALTER TABLE `da_reference_element` CHANGE `id_reference_element_instance` `id_reference_element_instance` INT( 8 ) NOT NULL AUTO_INCREMENT");
//    $this->execute("ALTER TABLE `da_reference_element` DROP INDEX `id_reference_2`");
    $this->execute("ALTER TABLE `da_rss` CHANGE `id_rss` `id_rss` SMALLINT( 5 ) UNSIGNED NOT NULL AUTO_INCREMENT");
    $this->execute("ALTER TABLE `da_site_module_template` CHANGE `id_module_template` `id_module_template` INT( 8 ) NOT NULL AUTO_INCREMENT");
    $this->execute("ALTER TABLE `da_system_parameter` CHANGE `id_system_parameter` `id_system_parameter` INT( 8 ) NOT NULL AUTO_INCREMENT");
    $this->execute("ALTER TABLE `pr_news` CHANGE `id_news` `id_news` INT( 8 ) NOT NULL AUTO_INCREMENT");
    $this->execute("ALTER TABLE `pr_news_category` CHANGE `id_news_category` `id_news_category` INT( 8 ) NOT NULL AUTO_INCREMENT");
    $this->execute("ALTER TABLE `pr_photogallery` CHANGE `id_photogallery` `id_photogallery` INT( 8 ) NOT NULL AUTO_INCREMENT");
    $this->execute("ALTER TABLE `pr_product` CHANGE `id_product` `id_product` INT( 8 ) NOT NULL AUTO_INCREMENT");
    $this->execute("ALTER TABLE `pr_product_brand` CHANGE `id_brand` `id_brand` INT( 8 ) NOT NULL AUTO_INCREMENT");
    $this->execute("ALTER TABLE `pr_product_category` CHANGE `id_product_category` `id_product_category` INT( 8 ) NOT NULL AUTO_INCREMENT");
    $this->execute("ALTER TABLE `pr_quiz` CHANGE `id_quiz` `id_quiz` INT( 8 ) NOT NULL AUTO_INCREMENT");
    $this->execute("ALTER TABLE `pr_quiz_answer` CHANGE `id_quiz_answer` `id_quiz_answer` INT( 8 ) NOT NULL AUTO_INCREMENT");
    $this->execute("ALTER TABLE `pr_quiz_question` CHANGE `id_quiz_question` `id_quiz_question` INT( 8 ) NOT NULL AUTO_INCREMENT");
    $this->execute("ALTER TABLE `pr_vitrine` CHANGE `id_vitrine` `id_vitrine` INT( 8 ) NOT NULL AUTO_INCREMENT");
    $this->execute("ALTER TABLE `pr_voting` CHANGE `id_voting` `id_voting` INT( 8 ) NOT NULL AUTO_INCREMENT");
    $this->execute("ALTER TABLE `pr_voting_answer` CHANGE `id_voting_answer` `id_voting_answer` INT( 8 ) NOT NULL AUTO_INCREMENT");
//    $this->execute("ALTER TABLE `da_site_theme` DROP `active`");
//    $this->execute("ALTER TABLE `da_site_theme` DROP `id_site_theme`");
    $this->execute("DROP TABLE IF EXISTS `da_site_theme`");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false);
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
