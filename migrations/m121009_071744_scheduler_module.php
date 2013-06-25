<?php

class m121009_071744_scheduler_module extends CDbMigration
{
	public function up()
	{
	  $this->execute("
	    ALTER TABLE `da_job` DROP `file_name`;
	  ");
	}

	public function down()
	{
		echo "m121009_071744_scheduler_module does not support migration down.\n";
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