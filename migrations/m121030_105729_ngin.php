<?php

class m121030_105729_ngin extends CDbMigration
{

	public function down()
	{
		echo "m121030_105729_ngin does not support migration down.\n";
		return false;
	}

	
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	  $this->execute("UPDATE `da_event_type` SET `name`='Интернет-магазин » Новая заявка на покупку' WHERE `da_event_type`.`id_event_type`=106;");
	  $this->execute("DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 35 AND id_instance = 104);");
	  $this->execute("DELETE FROM da_localization_element WHERE id_object = 35 AND id_instance = 104;");
	  $this->execute("DELETE FROM da_object_property_value WHERE id_object_instance=104 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=35);");
	  $this->execute("DELETE FROM da_event_type WHERE id_event_type=104;");
	}

}