<?php

class m121002_083734_shop_module extends CDbMigration
{
	public function up()
	{
	  $query = "
	    INSERT INTO da_object_parameters (id_parameter, id_parameter_type, caption, id_object, sequence, name, field_name, add_parameter, sql_parameter, default_value, not_null, need_locale, search, is_unique, group_type, is_additional, hint) VALUES ('1692', '2', 'Иконка', '529', '0', 'icon', 'icon', NULL, NULL, NULL, '0', '0', '0', '0', '0', '0', NULL);
     ALTER TABLE `pr_remain_status` ADD `icon` VARCHAR(255) ;
     UPDATE da_object_parameters SET sequence = @maxSeq + 1 WHERE id_parameter=1692;
     UPDATE pr_remain_status SET name = 'последняя штука', min_value = '0', max_value = '1', icon = 'icon-red' WHERE id_remain_status=2;
     UPDATE pr_remain_status SET name = 'мало', min_value = '1', max_value = '5', icon = 'icon-yellow' WHERE id_remain_status=3;
     UPDATE pr_remain_status SET name = 'много', min_value = '10', max_value = '999999999', icon = 'icon-green' WHERE id_remain_status=5;
	  ";
	  foreach (preg_split("~;(\n|\r)~s", $query, -1, PREG_SPLIT_NO_EMPTY) as $qLine) {
	    if (trim($qLine)) {
	      $this->execute(trim($qLine));
	    }
	  }
	}

	public function down()
	{
		echo "m121002_083734_shop_module does not support migration down.\n";
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