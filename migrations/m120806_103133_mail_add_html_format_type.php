<?php

class m120806_103133_mail_add_html_format_type extends CDbMigration
{
	public function up()
	{
	  $this->execute(
	    "INSERT INTO da_event_format (id_event_format, description, place, file_name, name) VALUES ('2', 'HTML-письмо', '1', NULL, 'HTML');"
	  );
	}

	public function down()
	{
		echo "m120806_103133_mail_add_html_format_type does not support migration down.\n";
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