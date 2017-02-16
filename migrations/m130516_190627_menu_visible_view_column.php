<?php

class m130516_190627_menu_visible_view_column extends CDbMigration
{

	public function down()
	{
		echo "m130516_190627_menu_visible_view_column does not support migration down.\n";
		return false;
	}

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
    $this->execute("INSERT INTO `da_object_view_column` (`id_object_view_column`, `id_object_view`, `id_object`, `caption`, `order_no`, `id_object_parameter`, `id_data_type`, `field_name`, `handler`, `visible`) VALUES
(6094, 54, 100, 'Видимость', 23, 5, 9, 'visible', NULL, 1);");
	}

}