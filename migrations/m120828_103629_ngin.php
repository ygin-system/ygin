<?php

class m120828_103629_ngin extends CDbMigration {
  public function up() {
    $this->execute("

UPDATE da_plugin SET `code`='ngin.news' WHERE `code`='ngin.modules.news.NewsPlugin';
UPDATE da_plugin SET `code`='ngin.search' WHERE `code`='ngin.modules.search.SearchPlugin';
UPDATE da_plugin SET `code`='ngin.feedback' WHERE `code`='ngin.modules.feedback.FeedbackPlugin';
UPDATE da_plugin SET `code`='ngin.photogallery' WHERE `code`='ngin.modules.photogallery.PhotogalleryPlugin';
UPDATE da_plugin SET `code`='ngin.shop' WHERE `code`='ngin.modules.shop.ShopPlugin';
UPDATE da_plugin SET `code`='ngin.faq' WHERE `code`='ngin.modules.faq.FaqPlugin';
UPDATE da_plugin SET `code`='ngin.vote' WHERE `code`='ngin.modules.vote.VotePlugin';

UPDATE da_module SET name = 'Баннер', id_object = NULL, id_module_handler = NULL, id_module_parent = NULL, id_child_parent_object = NULL WHERE id_module=300;
DELETE FROM da_module_view WHERE id_module = 300;

UPDATE da_php_script_type SET id_php_script_interface = '2', file_path = 'banners.widgets.specialOffer.SpecialOfferWidget', class_name = 'SpecialOfferWidget', description = 'Спецпредложения' WHERE id_php_script_type=1040;

ALTER TABLE `pr_banner_place` CHANGE `id_banner_place` `id_banner_place` INT( 11 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE `pr_banner` CHANGE `id_banner` `id_banner` INT( 8 ) NOT NULL AUTO_INCREMENT;


");
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
