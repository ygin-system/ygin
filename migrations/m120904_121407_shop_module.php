<?php

class m120904_121407_shop_module extends CDbMigration
{
	public function up()
	{
	  $this->execute("
	    INSERT INTO da_php_script_type_parameter (id_php_script_parameter, id_php_script_type, parameter_name, caption, default_value, eval) VALUES ('1028', '1010', 'visibleCount', 'Количество видимых позиций в корзине', '20', '0');
	  ");
	  $id = $this->dbConnection
	    ->createCommand('SELECT id_php_script FROM da_php_script WHERE id_php_script_type=1010 AND id_module=1004')
	    ->queryScalar();
	  if ($id) {
	    $this->execute("
        DELETE FROM da_php_script_parameter WHERE id_php_script=".$id.";
        INSERT INTO da_php_script_parameter (id_php_script, id_php_script_type, id_php_script_parameter, param_value) VALUES (".$id.", 1010, 1028, '20');
	    ");
	  }
	}

	public function down()
	{
		echo "m120904_121407_shop_module does not support migration down.\n";
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