<?php

class m140829_110544_subject extends CDbMigration
{
  public function safeUp() {
    $this->execute(" INSERT INTO `da_object_parameters` (`id_parameter_type`, `sequence`, `not_null`, `need_locale`, `search`, `is_additional`, `visible`, `id_object`, `group_type`, `caption`, `field_name`, `widget`, `add_parameter`, `sql_parameter`, `default_value`, `is_unique`, `hint`, `id_parameter`) VALUES (2, 0, 0, 0, 0, 0, 1, '49', 0, 'Тема', 'subject', 'subject', NULL, NULL, NULL, 0, '', '49-subject');");
    $this->execute("ALTER TABLE `da_event` ADD `subject` VARCHAR(255) COMMENT  'Тема';");
    $this->execute("UPDATE da_object_parameters SET sequence = 299 WHERE id_parameter='49-subject';");
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}