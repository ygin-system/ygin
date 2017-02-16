<?php

class m120820_135212_shop_module extends CDbMigration
{
	public function up()
	{
	  $this->execute("
	  INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('1665', '6', 'Статус', '519', '0', 'status', 'status', '101', NULL, NULL, '1', '0', '0', '0', '0', '0', NULL);
ALTER TABLE `pr_offer` ADD `status` INT(8) NOT NULL ;
UPDATE da_object_parameters SET sequence = @maxSeq + 1 WHERE id_parameter=1665;
	  ");
	}

	public function down()
	{
		echo "m120820_135212_shop_module does not support migration down.\n";
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