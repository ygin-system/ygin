<?php

class m140421_125604_struct_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("CREATE TABLE IF NOT EXISTS `pr_invoice` (                      `id_invoice` INT(8) NOT NULL  AUTO_INCREMENT ,                      PRIMARY KEY(`id_invoice`)                      ) ENGINE = InnoDB COMMENT='Счета'");
    $this->execute("ALTER TABLE `pr_invoice` ADD `create_date` INT(10) UNSIGNED NOT NULL COMMENT  'Дата создания'");
    $this->execute("ALTER TABLE `pr_invoice` ADD `pay_date` INT(10) UNSIGNED COMMENT  'Дата оплаты'");
    $this->execute("ALTER TABLE `pr_invoice` ADD `amount` INT(8) NOT NULL COMMENT  'Сумма'");
    $this->execute("ALTER TABLE `pr_invoice` ADD `id_offer` INT(8) NOT NULL COMMENT  'Заказ'");
    $this->execute("ALTER TABLE `pr_offer` ADD `amount` INT(8) NOT NULL COMMENT  'Сумма'");
    $this->execute("ALTER TABLE `pr_offer` ADD `id_invoice` INT(8) COMMENT  'Счет'");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
