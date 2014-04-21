<?php

class m140305_055619_ygin_banner_id extends CDbMigration
{
	public function up()
	{
    $this->execute("DELETE FROM `da_php_script_type` WHERE `id_php_script_type` = 300");
    $this->execute("
      INSERT INTO `da_php_script_type` SET
                   `id_php_script_type` = 'ygin-banner-widget-base',
                   `file_path` = 'ygin.modules.banners.widgets.BannerWidget',
                   `description` = 'Баннер',
                   `id_php_script_interface` = 2,
                   `active` = 0
    ");
  }

	public function down()
	{
		echo "m140305_055619_ygin_banner_id does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}