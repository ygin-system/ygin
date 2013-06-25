<?php

class m130514_104329_comments_module extends CDbMigration
{


	public function down()
	{
		echo "m130514_104329_comments_module does not support migration down.\n";
		return false;
	}

	public function safeUp()
	{
    $this->execute("INSERT INTO `da_php_script_type` (`id_php_script_type`, `active`, `id_php_script_interface`, `description`, `file_path`, `class_name`) VALUES (1046, 1, 1, 'Текст без тегов и заменой nl на br', 'yiigin.components.column.abstract.StrippedColumn', 'StrippedColumn');");
    $this->execute("UPDATE `da_php_script_type` SET `id_php_script_type`=1046, `file_path`='yiigin.components.column.abstract.StrippedColumn', `class_name`='StrippedColumn', `description`='Текст без тегов и заменой nl на br', `id_php_script_interface`=6, `active`=1 WHERE `da_php_script_type`.`id_php_script_type`=1046;");
    $this->execute("INSERT INTO `da_object_view_column` (`id_object_view_column`, `order_no`, `id_data_type`, `visible`, `id_object_view`, `id_object`, `caption`, `id_object_parameter`, `field_name`, `handler`) VALUES (6093, 0, 10, 1, 67, 250, 'Комментарий', 1207, 'comment_text', 1046);");
    $this->execute("UPDATE da_object_view_column SET order_no = 22 WHERE id_object_view_column='6093';");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
	}

}