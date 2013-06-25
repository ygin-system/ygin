<?php

class m121010_020603_ngin extends CDbMigration {
  public function up() {
    $this->execute("

UPDATE da_object SET sequence = '8', name = 'Голосование', object_type = '1', table_name = 'pr_voting', folder_name = 'content/vote/', field_caption = 'name', id_field_caption = '531', id_field_order = '536', order_type = '2', seq_start_value = '1', yii_model = NULL, id_object_handler = '409', id_instance_class = NULL, parent_object = '4', use_domain_isolation = '0' WHERE id_object=105;
DELETE FROM da_domain_object WHERE id_object = 105;
INSERT INTO da_domain_object(id_domain, id_object) 
                               VALUES(1, 105);

UPDATE da_object SET sequence = '9', name = 'Ответы на голосование', object_type = '1', table_name = 'pr_voting_answer', folder_name = NULL, field_caption = NULL, id_field_caption = NULL, id_field_order = NULL, order_type = '2', seq_start_value = '1', yii_model = NULL, id_object_handler = NULL, id_instance_class = NULL, parent_object = '105', use_domain_isolation = '0' WHERE id_object=106;
DELETE FROM da_domain_object WHERE id_object = 106;
INSERT INTO da_domain_object(id_domain, id_object) 
                               VALUES(1, 106);

UPDATE da_object_view SET icon_class = 'icon-check' WHERE id_object_view=58;

UPDATE da_object SET sequence = '7' WHERE id_object=105;
UPDATE da_object SET sequence = '8' WHERE id_object=520;
UPDATE da_object SET sequence = '9' WHERE id_object=521;
UPDATE da_object SET sequence = '10' WHERE id_object=250;
UPDATE da_object SET sequence = '11' WHERE id_object=261;
UPDATE da_object SET sequence = '12' WHERE id_object=102;
UPDATE da_object SET sequence = '13' WHERE id_object=530;

UPDATE da_object SET sequence = '8' WHERE id_object=250;
UPDATE da_object SET sequence = '9' WHERE id_object=520;
UPDATE da_object SET sequence = '10' WHERE id_object=521;

UPDATE da_object SET sequence = '11' WHERE id_object=530;
UPDATE da_object SET sequence = '12' WHERE id_object=261;
UPDATE da_object SET sequence = '13' WHERE id_object=102;

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
