<?php

class m120914_121927_ngin extends CDbMigration {
  public function up() {
    $this->execute("

INSERT INTO da_users (id_user, id_group, full_name, create_date, active, name, user_password, mail, rid) VALUES ('63', '4', 'Татьяна', '1347610383', '1', 'derevyankina', '13350f743ec5c385dc207067b67d9d48', NULL, NULL);

INSERT INTO `da_auth_assignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES ('dev', '60', NULL, 'N;');
INSERT INTO `da_auth_assignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES ('dev', '62', NULL, 'N;');
INSERT INTO `da_auth_assignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES ('editor', '63', NULL, 'N;');


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
