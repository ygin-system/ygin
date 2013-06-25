<?php

class m120820_134546_shop_module extends CDbMigration
{
	public function up()
	{
	  $this->execute("
	  CREATE TABLE IF NOT EXISTS `pr_link_offer_product` (
`id_offer` INT( 8 ) NOT NULL ,
`id_product` INT( 8 ) NOT NULL ,
`amount` INT NOT NULL ,
PRIMARY KEY ( `id_offer` , `id_product` )
) ENGINE = InnoDB;
ALTER TABLE `pr_offer` ENGINE = InnoDB;
ALTER TABLE `pr_product` ENGINE = InnoDB;
	  ");
	}

	public function down()
	{
		echo "m120820_134546_shop_module does not support migration down.\n";
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