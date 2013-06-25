<?php

class m120725_075905_add_field_to_system_parameters extends CDbMigration
{
	public function up()
	{
	  $this->execute(
  	  "INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('125', '14', 'Значение для больших текстовых данных (longtext)', '30', '0', 'long_text_value', 'long_text_value', NULL, NULL, NULL, '0', '0', '0', '0', '0', '1', NULL);
       ALTER TABLE `da_system_parameter` ADD `long_text_value` LONGTEXT ;
       UPDATE da_object_parameters SET sequence = @maxSeq + 1 WHERE id_parameter=125;"
	  );
	}

	public function down()
	{
		echo "m120725_075905_add_field_to_system_parameters does not support migration down.\n";
		return false;
	}
}