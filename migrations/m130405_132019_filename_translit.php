<?php

class m130405_132019_filename_translit extends CDbMigration
{

	public function down()
	{
		echo "m130405_132019_filename_translit does not support migration down.\n";
		return false;
	}

	
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	  $this->execute("INSERT INTO `da_system_parameter` (`id_system_parameter`, `id_group_system_parameter`, `name`, `value`, `note`, `id_parameter_type`, `long_text_value`) VALUES (101, 2, 'translit_uploaded_file_name', '1', 'Выполнять транслитерацию имен загружаемых файлов', 9, NULL);");
	}

}