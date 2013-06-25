<?php

class m130522_185724_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE da_php_script_type SET file_path=replace(file_path, 'yiigin', 'backend')");
    $this->execute("UPDATE da_object_parameters SET widget=replace(widget, 'yiigin', 'backend')");
    $this->execute("UPDATE da_object SET table_name=replace(table_name, 'yiigin', 'backend')");
    $this->execute("UPDATE da_object SET yii_model=replace(yii_model, 'yiigin', 'backend')");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
