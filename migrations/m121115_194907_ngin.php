<?php

class m121115_194907_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("INSERT INTO da_auth_item (`name`,`type`,`description`,`bizrule`,`data`) SELECT concat('delete_object_', id_object), 0, concat( 'Операция удаления экземпляра объекта ', name ), NULL, 'N;'
FROM (SELECT DISTINCT a.id_object, b.name FROM da_permissions a JOIN da_object b ON a.id_object=b.id_object WHERE a.id_permission_type=3) as t1");
    $this->execute("INSERT INTO da_auth_item_child (`parent`,`child`) SELECT 'editor', concat( 'delete_object_', id_object )
FROM (SELECT DISTINCT a.id_object FROM da_permissions a JOIN da_object b ON a.id_object=b.id_object WHERE a.id_group=4 AND a.id_permission_type=3) as t1");
    $this->execute("INSERT INTO da_auth_item_child (`parent`,`child`) SELECT 'dev', concat( 'delete_object_', id_object )
FROM (SELECT DISTINCT a.id_object FROM da_permissions a JOIN da_object b ON a.id_object=b.id_object WHERE a.id_group=1 AND a.id_permission_type=3) as t1");
    $this->execute("INSERT INTO da_auth_item (`name`,`type`,`description`,`bizrule`,`data`) SELECT concat('edit_object_', id_object), 0, concat( 'Операция изменения экземпляра объекта ', name ), NULL, 'N;'
FROM (SELECT DISTINCT a.id_object, b.name FROM da_permissions a JOIN da_object b ON a.id_object=b.id_object WHERE a.id_permission_type=2) as t1");
    $this->execute("INSERT INTO da_auth_item_child (`parent`,`child`) SELECT 'editor', concat( 'edit_object_', id_object )
FROM (SELECT DISTINCT a.id_object FROM da_permissions a JOIN da_object b ON a.id_object=b.id_object WHERE a.id_group=4 AND a.id_permission_type=2) as t1");
    $this->execute("INSERT INTO da_auth_item_child (`parent`,`child`) SELECT 'dev', concat( 'edit_object_', id_object )
FROM (SELECT DISTINCT a.id_object FROM da_permissions a JOIN da_object b ON a.id_object=b.id_object WHERE a.id_group=1 AND a.id_permission_type=2) as t1");
    $this->execute("INSERT INTO da_auth_item (`name`,`type`,`description`,`bizrule`,`data`) SELECT concat('view_object_', id_object), 0, concat( 'Операция просмотра экземпляра объекта ', name ), NULL, 'N;'
FROM (SELECT DISTINCT a.id_object, b.name FROM da_permissions a JOIN da_object b ON a.id_object=b.id_object WHERE a.id_permission_type=1) as t1");
    $this->execute("INSERT INTO da_auth_item_child (`parent`,`child`) SELECT 'editor', concat( 'view_object_', id_object )
FROM (SELECT DISTINCT a.id_object FROM da_permissions a JOIN da_object b ON a.id_object=b.id_object WHERE a.id_group=4 AND a.id_permission_type=1) as t1");
    $this->execute("INSERT INTO da_auth_item_child (`parent`,`child`) SELECT 'dev', concat( 'view_object_', id_object )
FROM (SELECT DISTINCT a.id_object FROM da_permissions a JOIN da_object b ON a.id_object=b.id_object WHERE a.id_group=1 AND a.id_permission_type=1) as t1");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false, false, false);
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
