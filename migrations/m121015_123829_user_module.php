<?php

class m121015_123829_user_module extends CDbMigration
{


	public function down()
	{
		echo "m121015_123829_user_module does not support migration down.\n";
		return false;
	}

	
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	  $this->execute("
	    ALTER TABLE `da_users` CHANGE `id_user` `id_user` INT( 8 ) NOT NULL AUTO_INCREMENT;
   ");
	  $this->execute("
	    ALTER TABLE `da_event_subscriber` CHANGE `id_event_subscriber` `id_event_subscriber` INT( 8 ) NOT NULL AUTO_INCREMENT;
	  ");
	}


	
}