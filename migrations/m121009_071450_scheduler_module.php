<?php

class m121009_071450_scheduler_module extends CDbMigration
{
	public function up()
	{
	  $this->execute("
	    ALTER TABLE `da_job` CHANGE `function_name` `class_name` VARCHAR(255) NOT NULL ;
	  ");
	}

	public function down()
	{
		echo "m121009_071450_scheduler_module does not support migration down.\n";
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