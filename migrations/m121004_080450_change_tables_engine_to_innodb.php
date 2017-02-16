<?php

class m121004_080450_change_tables_engine_to_innodb extends CDbMigration
{
	public function up()
	{
	  $tables = Yii::app()->db->createCommand('SHOW tables')->queryColumn();
	  $exclude = array(
	    'da_search_data',
	  );
	  foreach ($tables as $table) {
	    if (in_array($table, $exclude)) continue;
	    $this->execute('ALTER table `'.$table.'` ENGINE = InnoDB');
	  }
	}

	public function down()
	{
		echo "m121004_080450_change_tables_engine_to_innodb does not support migration down.\n";
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