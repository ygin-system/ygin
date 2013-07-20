<?php

class m130714_230340_ygin extends CDbMigration {
  public function safeUp() {

    $command = $this->dbConnection
        ->createCommand('SELECT id_instance FROM da_search_data WHERE id_object=:obj_old AND id_instance IN (SELECT id_instance FROM da_search_data WHERE id_object=:obj_new)');
    $data = $command->queryAll(true, array(':obj_old' => '100', ':obj_new' => 'ygin-menu'));

    foreach($data AS $row)
      $this->execute("DELETE FROM da_search_data WHERE id_object=:obj AND id_instance=:inst", array(':obj' => '100', ':inst' => $row['id_instance']));

    $this->execute("UPDATE da_search_data SET id_object = 'ygin-menu' WHERE id_object='100'");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
