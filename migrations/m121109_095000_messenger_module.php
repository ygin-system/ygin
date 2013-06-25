<?php

class m121109_095000_messenger_module extends CDbMigration
{
	public function down()
	{
		echo "m121109_095000_messenger_module does not support migration down.\n";
		return false;
	}

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	  $this->execute("INSERT INTO `da_object` (`id_object`,`sequence`, `name`, `object_type`, `table_name`, `folder_name`, `field_caption`, `id_field_caption`, `id_field_order`, `order_type`, `seq_start_value`, `yii_model`, `id_object_handler`, `id_instance_class`, `parent_object`, `use_domain_isolation`) VALUES (531, 0, 'Уведомления', 1, 'da_message', 'content/messages', NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 1, 0);");
	  $this->execute("INSERT INTO `da_object_parameters` (`id_parameter`,`id_parameter_type`, `sequence`, `not_null`, `is_unique`, `need_locale`, `search`, `is_additional`, `id_object`, `caption`, `name`, `field_name`) VALUES (1693, 11, 1, 1, 0, 0, 0, 0, 531, 'id', 'id_message', 'id_message');");
	  $this->execute("INSERT INTO `da_object_parameters` (`id_parameter`,`id_parameter_type`, `caption`, `id_object`, `sequence`, `name`, `field_name`, `add_parameter`, `sql_parameter`, `default_value`, `not_null`, `need_locale`, `search`, `is_unique`, `group_type`, `is_additional`, `hint`) VALUES (1694, 14, 'Текст', 531, 0, 'text', 'text', NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, NULL);");
	  $this->execute("INSERT INTO `da_object_parameters` (`id_parameter`,`id_parameter_type`, `caption`, `id_object`, `sequence`, `name`, `field_name`, `add_parameter`, `sql_parameter`, `default_value`, `not_null`, `need_locale`, `search`, `is_unique`, `group_type`, `is_additional`, `hint`) VALUES (1695, 4, 'Дата создания', 531, 0, 'date', 'date', NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, NULL);");
	  $this->execute("INSERT INTO `da_object_parameters` (`id_parameter`,`id_parameter_type`, `caption`, `id_object`, `sequence`, `name`, `field_name`, `add_parameter`, `sql_parameter`, `default_value`, `not_null`, `need_locale`, `search`, `is_unique`, `group_type`, `is_additional`, `hint`) VALUES (1696, 1, 'тип', 531, 0, 'type', 'type', NULL, NULL, '1', 1, 0, 0, 0, 0, 0, NULL);");
	  $this->execute("UPDATE `da_object` SET `id_object`=531, `name`='Уведомления', `id_field_order`=1695, `order_type`=2, `table_name`='da_message', `id_field_caption`=1694, `object_type`=1, `folder_name`='content/messages', `parent_object`=1, `sequence`=50, `seq_start_value`=1, `use_domain_isolation`=0, `id_object_handler`=NULL, `id_instance_class`=NULL, `field_caption`='text', `yii_model`='Message' WHERE `da_object`.`id_object`=531;");
	  $this->execute("INSERT INTO `da_auth_item` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('list_object_531', 0, 'Просмотр списка данных объекта ид=531', NULL, 'N;');");
	  $this->execute("INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('dev', 'list_object_531');");
	  $this->execute("INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('editor', 'list_object_531');");
	}

}