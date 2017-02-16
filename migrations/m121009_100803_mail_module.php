<?php

class m121009_100803_mail_module extends CDbMigration
{


	public function down()
	{
		echo "m121009_100803_mail_module does not support migration down.\n";
		return false;
	}

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	  $this->execute("
	    UPDATE da_job SET name = 'Отсылка сообщений', active = '1', interval_value = '90', error_repeat_interval = '180', last_start_date = '1344593833', next_start_date = '1344593882', failures = '0', class_name = 'ngin.modules.mail.components.DispatchEvents', first_start_date = '1313061006', priority = '0', start_date = NULL, max_second_process = '120' WHERE id_job=1;
	  ");
	}

}