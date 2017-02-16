<?php

class m121004_055741_ngin extends CDbMigration
{
	public function up()
	{
	  $this->execute("ALTER TABLE `da_event_type` CHANGE `id_event_type` `id_event_type` INT( 8 ) NOT NULL AUTO_INCREMENT");
	}

	public function down()
	{
		echo "m121004_055741_ngin does not support migration down.\n";
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