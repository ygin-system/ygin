<?php

class m120810_102553_update_shop_offer_event_type extends CDbMigration
{
	public function up()
	{
	  $this->execute("
	    UPDATE da_event_type SET name = 'Оформлена новая заявка', id_mail_account = '10', id_object = '519', last_time = NULL, sql_condition = NULL, condition_done = NULL, interval_value = '90' WHERE id_event_type=106;
	  ");
	}

	public function down()
	{
		echo "m120810_102553_update_shop_offer_event_type does not support migration down.\n";
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