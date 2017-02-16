<?php

class m121109_131529_messenger_module extends CDbMigration
{


	public function down()
	{
		echo "m121109_131529_messenger_module does not support migration down.\n";
		return false;
	}

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	  $this->execute("DELETE FROM da_domain_object WHERE id_object = 531;");
	  $this->execute("INSERT INTO da_permissions (id_permission, id_group, id_object, id_permission_type) VALUES ('1185', '1', '531', '1');");
	  $this->execute("INSERT INTO da_domain_object(id_domain, id_object) VALUES(1, 531);");
	  $this->execute("INSERT INTO da_permissions (id_permission, id_group, id_object, id_permission_type) VALUES ('1186', '1', '531', '2');");
	  $this->execute("INSERT INTO da_permissions (id_permission, id_group, id_object, id_permission_type) VALUES ('1187', '1', '531', '3');");
	  $this->execute("INSERT INTO da_permissions (id_permission, id_group, id_object, id_permission_type) VALUES ('1188', '4', '531', '1');");
	  $this->execute("INSERT INTO da_object_view (id_object_view, name, id_object, sql_order_by) VALUES ('2026', 'Уведомления', '531', 'date DESC');");
	  $this->execute("INSERT INTO da_object_view_column (id_object_view_column, id_object_view, id_object, id_object_parameter, caption, id_data_type, field_name) VALUES ('6091', '2026', '531', '1694', 'Текст', '14', 'text');");
	  $this->execute("INSERT INTO da_object_view_column (id_object_view_column, id_object_view, id_object, id_object_parameter, caption, id_data_type, field_name) VALUES ('6092', '2026', '531', '1695', 'Дата создания', '4', 'date');");
	}
}