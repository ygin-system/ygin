<?php

class m120828_164130_ngin extends CDbMigration {
  public function up() {
    $this->execute("

INSERT INTO da_php_script_type (id_php_script_type, id_php_script_interface, file_path, class_name, description) VALUES ('1044', '2', 'ngin.widgets.cloudim.CloudimWidget', 'CloudimWidget', 'Онлайн-консультации Cloudim');
INSERT INTO da_module (id_module, name) VALUES ('1015', 'Онлайн-консультации Cloudim');
INSERT INTO da_module_view(id_module, id_php_script_type) VALUES(1015, 1044);
INSERT INTO da_domain_module(id_domain, id_module) VALUES(1, 1015);


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
