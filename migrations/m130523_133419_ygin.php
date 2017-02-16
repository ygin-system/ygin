<?php

class m130523_133419_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE da_job SET class_name=replace(class_name, 'ngin.', 'ygin.')");
    $this->execute("UPDATE da_object_parameters SET hint=replace(hint, 'ngin.', 'ygin.')");
    $this->execute("UPDATE da_object SET yii_model=replace(yii_model, 'ngin.', 'ygin.')");
    $this->execute("UPDATE da_php_script_type SET file_path=replace(file_path, 'ngin.', 'ygin.')");
    $this->execute("UPDATE da_plugin SET code=replace(code, 'ngin.', 'ygin.')");
    $this->execute("UPDATE da_plugin SET class_name=replace(class_name, 'ngin.', 'ygin.')");
    $this->execute("UPDATE da_plugin SET config=replace(config, 'ngin.', 'ygin.')");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
