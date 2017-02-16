<?php

class m120807_114536_make_autoincrement_pk_for_da_event extends CDbMigration
{
	public function up()
	{
	  $this->execute("
	    ALTER TABLE `da_event` CHANGE `id_event` `id_event` INT( 8 ) NOT NULL AUTO_INCREMENT;
	  ");
	}

	public function down()
	{
		echo "m120807_114536_make_autoincrement_pk_for_da_event does not support migration down.\n";
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