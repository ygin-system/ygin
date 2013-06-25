<?php

class m121009_071615_scheduler_module extends CDbMigration
{

	public function down()
	{
		echo "m121009_071615_scheduler_module does not support migration down.\n";
		return false;
	}

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	  $this->execute("
	    UPDATE da_object_parameters SET id_parameter_type = '2', caption = 'Имя класса задачи', id_object = '51', sequence = '11', name = 'class_name', field_name = 'class_name', add_parameter = NULL, sql_parameter = NULL, default_value = NULL, not_null = '1', need_locale = '0', search = '0', is_unique = '0', group_type = '0', is_additional = '0', hint = NULL WHERE id_parameter=276;
	    UPDATE da_object_view_column SET id_object_view = '33', id_object = '51', caption = 'Имя класса задачи', visible = '1', order_no = '5', id_object_parameter = '276', id_data_type = '2', field_name = 'class_name', handler = NULL WHERE id_object_view_column=69;
     DELETE FROM da_localization_element_value WHERE id_localization_element IN (SELECT id_localization_element FROM da_localization_element WHERE id_object = 21 AND id_instance = 275);
     DELETE FROM da_localization_element WHERE id_object = 21 AND id_instance = 275;
     DELETE FROM da_object_property_value WHERE id_object_instance=275 AND ID_PROPERTY IN (SELECT ID_PROPERTY FROM da_object_property WHERE id_object=21);
     DELETE FROM da_object_parameters WHERE id_parameter=275;
	  ");
	}

}