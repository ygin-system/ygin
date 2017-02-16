<?php

class m120904_150721_ngin extends CDbMigration {
  public function up() {
    $this->execute("

INSERT INTO da_auth_item (`name`,`type`,`description`,`bizrule`,`data`) SELECT concat( 'create_object_', id_object ), 0, concat( 'Операция создание экземпляра объекта ', name ), NULL, 'N;'
FROM (SELECT DISTINCT a.id_object, b.name FROM da_permissions a JOIN da_object b ON a.id_object=b.id_object WHERE a.id_permission_type=4) as t1;

INSERT INTO da_auth_item_child (`parent`,`child`) SELECT 'editor', concat( 'create_object_', id_object )
FROM (SELECT DISTINCT a.id_object FROM da_permissions a JOIN da_object b ON a.id_object=b.id_object WHERE a.id_group=4 AND a.id_permission_type=4) as t1;

INSERT INTO da_auth_item_child (`parent`,`child`) SELECT 'dev', concat( 'create_object_', id_object )
FROM (SELECT DISTINCT a.id_object FROM da_permissions a JOIN da_object b ON a.id_object=b.id_object WHERE a.id_group=1 AND a.id_permission_type=4) as t1;

");
  }
  
  public function down() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }

  /*
  public function safeUp() {
  }
  public function safeDown() {
  }
  */
}
