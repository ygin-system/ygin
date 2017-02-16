<?php

class m120807_083424_drop_field_send_status_from_faq extends CDbMigration
{
	public function up()
	{
	  $this->execute("
	    UPDATE da_event_type SET name = 'Вопрос-ответ » Новый вопрос', id_mail_account = '10', id_object = '512', last_time = NULL, sql_condition = NULL, condition_done = NULL, interval_value = '90' WHERE id_event_type=103;
      ALTER TABLE `pr_question` DROP `send_status`;
	  ");
	}

	public function down()
	{
		echo "m120807_083424_drop_field_send_status_from_faq does not support migration down.\n";
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