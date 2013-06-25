<?php

class m121025_130718_ngin extends CDbMigration
{


	public function down()
	{
		echo "m121025_130718_ngin does not support migration down.\n";
		return false;
	}

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	  $this->execute("ALTER TABLE `da_menu` ADD UNIQUE `alias` ( `alias` ) ");
	}

}