<?php
	class m130116_075255_messanger_module extends CDbMigration {
		public function safeUp() {
	    $this->execute("ALTER TABLE  `da_message` ADD  `sender` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
	
	    $path = dirname(__FILE__)."/../../assets/";
	    HFile::removeDirectoryRecursive($path, false, false, false);
  	}

		public function down() {
			echo "m130116_075255_messanger_module does not support migration down.\n";
			return false;
		}
	}