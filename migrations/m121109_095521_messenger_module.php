<?php

class m121109_095521_messenger_module extends CDbMigration
{


	public function down()
	{
		echo "m121109_095521_messenger_module does not support migration down.\n";
		return false;
	}

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	  $this->execute("CREATE TABLE IF NOT EXISTS `da_message` (                     `id_message` INT(8) NOT NULL  AUTO_INCREMENT ,                     PRIMARY KEY(`id_message`)                     ) ENGINE = InnoDB;");
	  $this->execute("ALTER TABLE `da_message` ADD `text` LONGTEXT NOT NULL;");
	  $this->execute("ALTER TABLE `da_message` ADD `date` INT(10) UNSIGNED NOT NULL;");
	  $this->execute("ALTER TABLE `da_message` ADD `type` INT(8) NOT NULL default '1';");
	}

}