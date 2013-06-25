<?php

class m121016_131442_struct_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE da_object SET sequence = '7', name = 'Данные агрегатора', object_type = '1', table_name = 'da_aggregator_data', folder_name = NULL, field_caption = 'create_date', id_field_caption = NULL, id_field_order = NULL, order_type = '1', seq_start_value = '1', yii_model = NULL, id_object_handler = NULL, id_instance_class = NULL, parent_object = '5', use_domain_isolation = '0' WHERE id_object=79");
    $this->execute("DELETE FROM `da_auth_item` WHERE `da_auth_item`.`name` = 'create_object_81' LIMIT 1");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false);
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
