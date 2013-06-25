<?php

class m120918_081514_shop_module extends CDbMigration
{
	public function up()
	{
	  $this->execute("
	    -- Виджет категорий
     UPDATE da_php_script_type SET id_php_script_interface = '2', file_path = 'shop.widgets.category.CategoryWidget', class_name = 'CategoryWidget', description = 'Интернет-магазин » Категории' WHERE id_php_script_type=1038;
     -- Виджет брендов
     UPDATE da_php_script_type SET id_php_script_interface = '2', file_path = 'shop.widgets.brand.BrandWidget', class_name = 'BrandWidget', description = 'Интернет-магазин » Брэнды' WHERE id_php_script_type=1043;
	  ");
	}

	public function down()
	{
		echo "m120918_081514_shop_module does not support migration down.\n";
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