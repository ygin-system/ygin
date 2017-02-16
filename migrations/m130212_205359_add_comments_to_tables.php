<?php

class m130212_205359_add_comments_to_tables extends CDbMigration
{
	public function up()
	{
	  $realTables = $this->dbConnection->createCommand('SHOW TABLES')->queryColumn();
	  foreach ($this->dbConnection->createCommand('SELECT `id_object`, `name`, `table_name` FROM `da_object` WHERE table_name IS NOT NULL')->queryAll(true) as $tableRow) {
	    $tableName = $tableRow['table_name'];
	    $tableComment = $tableRow['name'];
	    $idObject = $tableRow['id_object'];
	    if (!in_array($tableName, $realTables)) continue;
	    $realColumns = $this->dbConnection->createCommand('SHOW FULL COLUMNS FROM `'.$tableName.'`')->queryAll();
	    $alterSql = 'ALTER TABLE  `'.$tableName.'`';
	    $cmd = $this->dbConnection->createCommand('SELECT `caption`, `field_name` FROM `da_object_parameters` WHERE `id_object` = :ID_O');
	    $first = true;
	    foreach ($cmd->queryAll(true, array(':ID_O' => $idObject)) as $propertyRow) {
	      $filedName = $propertyRow['field_name'];
	      $fieldComment = $propertyRow['caption'];
	      
	      $curColumn = null;
	      foreach ($realColumns as $realColumn) {
	        if ($realColumn['Field'] == $filedName) {
	          $curColumn = $realColumn;
	          break;
	        }
	      }
	      if (empty($curColumn)) continue;
	      
        if (!$first) {
          $alterSql .= ',';
        } else {
          $first = false;
        }
        $definition = "\nCHANGE `".$filedName."` `".$filedName."`";
        $definition .= ' '.$realColumn['Type'];
        if ($realColumn['Collation']) {
          $definition .= ' COLLATE '.$realColumn['Collation'];
        }
        if ($realColumn['Null'] == 'YES') {
          $definition .= ' NULL';
        } else {
          $definition .= ' NOT NULL';
        }
        if ($realColumn['Default'] === null) {
          if ($realColumn['Null'] == 'YES') {
            $definition .= ' DEFAULT NULL';
          }
        } else {
          $definition .= ' DEFAULT '.$this->dbConnection->quoteValue($realColumn['Default']);
        }
        if ($realColumn['Extra'] == 'auto_increment') {
          $definition .= ' AUTO_INCREMENT';
        }
        $definition .= " COMMENT ".$this->dbConnection->quoteValue($fieldComment);
        $alterSql .= $definition;
	    }
	    $this->execute($alterSql);
	    $this->execute('ALTER TABLE  `'.$tableName.'` COMMENT =  '.$this->dbConnection->quoteValue($tableComment));
	  }
	}

	public function down()
	{
		echo "m130212_205359_add_comments_to_tables does not support migration down.\n";
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