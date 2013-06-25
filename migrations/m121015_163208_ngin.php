<?php

class m121015_163208_ngin extends CDbMigration {
  public function safeUp() {

    $this->execute("DROP TABLE IF EXISTS `da_aggregator`, `da_aggregator_data`, `da_aggregator_type`, `da_currency`, `da_currency_rate`, `da_php_script_parameter`, `da_php_script_type_parameter`, `da_rules_process_text`;");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false);
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
