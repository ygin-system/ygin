<?php

class m121010_133117_ngin extends CDbMigration
{

	public function down()
	{
		echo "m121010_133117_ngin does not support migration down.\n";
		return false;
	}

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	  //Добавим права Ксюше
	  if (Yii::app()->db->createCommand('SELECT userid FROM da_auth_assignment WHERE userid = 61')->queryScalar() == null) {
	    $this->execute("
	      INSERT INTO `da_auth_assignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES ('dev', '61', NULL, 'N;');
	    ");
	  }
	  
	}

}