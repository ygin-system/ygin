<?php

class m130423_122356_new_users_password extends CDbMigration
{

  public function down()
  {
    echo "m130423_122356_new_users_password does not support migration down.\n";
    return false;
  }

  // Use safeUp/safeDown to do migration with transaction
  public function safeUp()
  {
    $this->execute("UPDATE da_users SET password_strategy = 'legacy'");
  }

}