<?php

class m120820_134744_shop_module extends CDbMigration
{
	public function up()
	{
	    $this->execute("
	    INSERT INTO da_references (id_reference, name) VALUES ('101', 'Статус заказа пользователя');
INSERT INTO da_reference_element (id_reference_element_instance, id_reference, id_reference_element, value, image_element) VALUES ('504', '101', '1', 'Новый', NULL);
INSERT INTO da_reference_element (id_reference_element_instance, id_reference, id_reference_element, value, image_element) VALUES ('505', '101', '2', 'Согласован', NULL);
INSERT INTO da_reference_element (id_reference_element_instance, id_reference, id_reference_element, value, image_element) VALUES ('506', '101', '3', 'Оплачен', NULL);
INSERT INTO da_reference_element (id_reference_element_instance, id_reference, id_reference_element, value, image_element) VALUES ('507', '101', '4', 'Выполнен', NULL);
INSERT INTO da_reference_element (id_reference_element_instance, id_reference, id_reference_element, value, image_element) VALUES ('508', '101', '5', 'Отменен', NULL);
	    ");
	}

	public function down()
	{
		echo "m120820_134744_shop_module does not support migration down.\n";
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