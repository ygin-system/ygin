<?php

class m120807_065040_drop_field_is_send_from_feedback extends CDbMigration
{
	public function up()
	{
	  $this->execute("
	    UPDATE da_event_type SET name = 'Новое сообщение с формы обратной связи', id_mail_account = '10', id_object = '517', last_time = NULL, sql_condition = NULL, condition_done = NULL, interval_value = '90' WHERE id_event_type=105;
      ALTER TABLE `pr_feedback` DROP `is_send`;
	  ");
	}

	public function down()
	{
		echo "m120807_065040_drop_field_is_send_from_feedback does not support migration down.\n";
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