<?php

class m120731_211556_ngin extends CDbMigration {
  public function up() {
    $this->execute("

INSERT INTO da_auth_item (`name`,`type`,`description`,`bizrule`,`data`) SELECT concat( 'list_object_', id_object ), 0, concat( 'Просмотр списка данных объекта ', name ), NULL, 'N;'
FROM (SELECT DISTINCT a.id_object, b.name FROM da_permissions a JOIN da_object b ON a.id_object=b.id_object) as t1;

INSERT INTO da_auth_item_child (`parent`,`child`) SELECT 'editor', concat( 'list_object_', id_object )
FROM (SELECT DISTINCT a.id_object FROM da_permissions a JOIN da_object b ON a.id_object=b.id_object WHERE a.id_group=4) as t1;

INSERT INTO da_auth_item_child (`parent`,`child`) SELECT 'dev', concat( 'list_object_', id_object )
FROM (SELECT DISTINCT a.id_object FROM da_permissions a JOIN da_object b ON a.id_object=b.id_object WHERE a.id_group=1 AND a.id_object not in (SELECT DISTINCT a.id_object FROM da_permissions a WHERE a.id_group=4)) as t1;

delete from da_auth_item where name in ('list_object_7', 'list_object_38', 'list_object_69', 'list_object_62', 'list_object_44', 'list_object_46');


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
