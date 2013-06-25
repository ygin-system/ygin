<?php

class m121102_141700_news_module extends CDbMigration
{


	public function down()
	{
		echo "m121102_141700_news_module does not support migration down.\n";
		return false;
	}

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	  $this->execute("UPDATE `da_object` SET `id_object`=502, `name`='Новости', `id_field_order`=1516, `order_type`=2, `table_name`='pr_news', `id_field_caption`=NULL, `object_type`=1, `folder_name`='content/news', `parent_object`=4, `sequence`=2, `seq_start_value`=1, `use_domain_isolation`=0, `id_object_handler`=NULL, `id_instance_class`=NULL, `field_caption`=NULL, `yii_model`='news.models.News' WHERE `da_object`.`id_object`=502;");
	}

	
}