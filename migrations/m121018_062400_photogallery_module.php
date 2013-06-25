<?php

class m121018_062400_photogallery_module extends CDbMigration
{

	public function down()
	{
		echo "m121018_062400_photogallery_module does not support migration down.\n";
		return false;
	}

	
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	  $this->execute("
	    INSERT INTO da_php_script_type (id_php_script_type, id_php_script_interface, file_path, class_name, description) VALUES ('1045', '2', 'photogallery.widgets.randomPhoto.RandomPhotoWidget', 'photogallery.widgets.randomPhoto.RandomPhotoWidget', 'Случайное фото');
	  ");
	  $this->execute("
	    UPDATE da_module SET name = 'Фотогалерея', id_object = NULL, id_module_handler = NULL, id_module_parent = NULL, id_child_parent_object = NULL WHERE id_module=1000;
	  ");
	  $this->execute("
	    DELETE FROM da_module_view WHERE id_module = 1000;
	  ");
	  $this->execute("
	    INSERT INTO da_module_view(id_module, id_php_script_type) VALUES(1000, 1045);
	  ");
	  $this->execute("
	    INSERT INTO da_module_view(id_module, id_php_script_type) VALUES(1000, 1000);
	  ");
	}

	
}