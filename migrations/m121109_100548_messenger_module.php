<?php

class m121109_100548_messenger_module extends CDbMigration
{


	public function down()
	{
		echo "m121109_100548_messenger_module does not support migration down.\n";
		return false;
	}

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	  $this->execute("CREATE TABLE  `da_link_message_user` (
    `id_message` INT( 8 ) NOT NULL ,
    `id_user` INT( 8 ) NOT NULL ,
    PRIMARY KEY (  `id_message` ,  `id_user` )
    ) ENGINE = INNODB;");
	}


}