<?php

class m130820_064119_comments_column extends CDbMigration
{

	public function down()
	{
		echo "m130820_064119_comments_column does not support migration down.\n";
		return false;
	}


	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
    $this->execute("UPDATE `da_php_script_type` SET `id_php_script_type`='250', `file_path`='comments.backend.CommentsColumn', `description`='Комментарии » Комментарии экземпляра', `id_php_script_interface`=6, `active`=1 WHERE `da_php_script_type`.`id_php_script_type`='250';");
    $this->execute("DELETE FROM `da_php_script_type` WHERE `id_php_script_type` = 251;");
    $this->execute("UPDATE `da_php_script_type` SET `id_php_script_type`='443', `file_path`='comments.backend.CommentsViewLinkColumn', `description`='Комментарии » Ссылка на объект', `id_php_script_interface`=6, `active`=1 WHERE `da_php_script_type`.`id_php_script_type`='443';");
    $this->execute("UPDATE `da_object_view` SET `id_object_view`='67', `id_object`='250', `name`='Комментарии', `order_no`=1, `visible`=1, `sql_select`='id_object, id_instance', `sql_from`=NULL, `sql_where`=NULL, `sql_order_by`='comment_date ASC', `count_data`=50, `icon_class`='icon-comment', `id_parent`='id_parent' WHERE `da_object_view`.`id_object_view`='67';");
	}
}