<?php

class m121005_071430_menu_module extends CDbMigration
{

	public function down()
	{
		echo "m121005_071430_menu_module does not support migration down.\n";
		return false;
	}

	
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	  $this->execute("
	    INSERT INTO da_reference_element (id_reference_element_instance, id_reference, id_reference_element, value, image_element) VALUES ('509', '33', '4', 'Не выводить предупреждение, отобразить пустую страницу', NULL);
	  ");
	}
	
}