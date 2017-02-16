<?php

class m130620_143445_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=4 WHERE `da_object_parameters`.`id_object`='21' AND `da_object_parameters`.`id_parameter`='77'");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=5 WHERE `da_object_parameters`.`id_object`='21' AND `da_object_parameters`.`id_parameter`='80'");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=6 WHERE `da_object_parameters`.`id_object`='21' AND `da_object_parameters`.`id_parameter`='74'");
    $this->execute("UPDATE da_object SET id_object=replace(id_object, '.', '-')");
    $this->execute("UPDATE da_object_parameters SET id_object=replace(id_object, '.', '-')");
    $this->execute("UPDATE da_object_parameters SET add_parameter=replace(add_parameter, '.', '-') WHERE id_parameter_type=7");
    $this->execute("UPDATE da_object_view SET id_object=replace(id_object, '.', '-')");
    $this->execute("UPDATE da_object_view_column SET id_object=replace(id_object, '.', '-')");
    $this->execute("UPDATE da_files SET id_object=replace(id_object, '.', '-')");
    $this->execute("UPDATE da_search_data SET id_object=replace(id_object, '.', '-')");
    $this->execute("UPDATE da_object_view SET id_object_view=replace(id_object_view, '.', '-')");
    $this->execute("UPDATE da_object_view_column SET id_object_view=replace(id_object_view, '.', '-')");
    $this->execute("UPDATE da_object_view_column SET id_object_view_column=replace(id_object_view_column, '.', '-')");
    $this->execute("UPDATE da_object_parameters SET id_parameter=replace(id_parameter, '.', '-')");
    $this->execute("UPDATE da_object SET id_field_order=replace(id_field_order, '.', '-')");
    $this->execute("UPDATE da_object SET id_field_caption=replace(id_field_caption, '.', '-')");
    $this->execute("UPDATE da_files SET id_parameter=replace(id_parameter, '.', '-')");
    $this->execute("UPDATE da_object_view_column SET id_object_parameter=replace(id_object_parameter, '.', '-')");
    $this->execute("UPDATE da_system_parameter SET id_system_parameter=replace(id_system_parameter, '.', '-')");
    $this->execute("UPDATE da_job SET id_job=replace(id_job, '.', '-')");
    $this->execute("UPDATE da_php_script_type SET id_php_script_type=replace(id_php_script_type, '.', '-')");
    $this->execute("UPDATE da_php_script SET id_php_script_type=replace(id_php_script_type, '.', '-')");
    $this->execute("UPDATE da_object_view_column SET handler=replace(handler, '.', '-')");
    $this->execute("UPDATE da_references SET id_reference=replace(id_reference, '.', '-')");
    $this->execute("UPDATE da_reference_element SET id_reference=replace(id_reference, '.', '-')");
    $this->execute("UPDATE da_reference_element SET id_reference_element_instance=replace(id_reference_element_instance, '.', '-')");

    $command = $this->dbConnection
        ->createCommand('SELECT name, type, description, bizrule, data FROM da_auth_item WHERE name LIKE :like');
    $command->params = array(':like' => '%.%');
    $data1 = $command->queryAll();
    $command = $this->dbConnection
        ->createCommand('SELECT parent, child FROM da_auth_item_child WHERE child LIKE :like');
    $command->params = array(':like' => '%.%');
    $data2 = $command->queryAll();
    foreach($data1 AS $row) {
      $this->execute("DELETE FROM da_auth_item WHERE name=:name", array(':name' => $row['name']));
      $this->execute("INSERT INTO da_auth_item (name, type, description, bizrule, data) VALUES (:n, :t, :d, :b, :data)", array(
        ':n' => str_replace('.', '-', $row['name']),
        ':t' => $row['type'],
        ':d' => $row['description'],
        ':b' => $row['bizrule'],
        ':data' => $row['data'],
      ));
    }
    foreach($data2 AS $row) {
      $this->execute("DELETE FROM da_auth_item_child WHERE child=:name", array(':name' => $row['child']));
      $this->execute("INSERT INTO da_auth_item_child (child, parent) VALUES (:c, :p)", array(
        ':c' => str_replace('.', '-', $row['child']),
        ':p' => $row['parent'],
      ));
    }

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
