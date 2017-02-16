<?php

class m120919_073944_shop_module extends CDbMigration
{
	public function up()
	{
	  $this->execute("
	    -- Добавил поле видео для объекта товар
	    INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('1691', '14', 'Видео', '511', '0', 'video', 'video', NULL, NULL, NULL, '0', '0', '0', '0', '0', '1', 'HTML-код видео (напр. с сайта youtube.com)');
     ALTER TABLE `pr_product` ADD `video` LONGTEXT ;
     UPDATE da_object_parameters SET sequence = @maxSeq + 1 WHERE id_parameter=1691;
	  ");
	}

	public function down()
	{
		echo "m120919_073944_shop_module does not support migration down.\n";
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