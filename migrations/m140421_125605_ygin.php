<?php

class m140421_125605_ygin extends CDbMigration {
  public function safeUp() {

    // обновление
    $exists = $this->dbConnection
        ->createCommand("SHOW TABLES LIKE 'pr_invoice'")
        ->queryScalar();
    if ($exists == null) {
      $this->execute("CREATE TABLE IF NOT EXISTS `pr_invoice` (                      `id_invoice` INT(8) NOT NULL  AUTO_INCREMENT ,                      PRIMARY KEY(`id_invoice`)                      ) ENGINE = InnoDB COMMENT='Счета'");
      $this->execute("ALTER TABLE `pr_invoice` ADD `create_date` INT(10) UNSIGNED NOT NULL COMMENT  'Дата создания'");
      $this->execute("ALTER TABLE `pr_invoice` ADD `pay_date` INT(10) UNSIGNED COMMENT  'Дата оплаты'");
      $this->execute("ALTER TABLE `pr_invoice` ADD `amount` INT(8) NOT NULL COMMENT  'Сумма'");
      $this->execute("ALTER TABLE `pr_invoice` ADD `id_offer` INT(8) NOT NULL COMMENT  'Заказ'");
      $this->execute("ALTER TABLE `pr_offer` ADD `amount` INT(8) NOT NULL COMMENT  'Сумма'");
      $this->execute("ALTER TABLE `pr_offer` ADD `id_invoice` INT(8) COMMENT  'Счет'");

      $this->execute("INSERT INTO `da_object` (`order_type`, `object_type`, `sequence`, `use_domain_isolation`, `parent_object`, `id_object`, `name`, `table_name`, `folder_name`, `field_caption`, `id_field_caption`, `id_field_order`, `yii_model`) VALUES (1, 1, 0, 0, '518', 'ygin-invoice', 'Счета', 'pr_invoice', NULL, NULL, '', '', NULL)");
      $this->execute("INSERT INTO `da_object_parameters` (`id_parameter_type`, `sequence`, `not_null`, `need_locale`, `search`, `is_additional`, `visible`, `id_object`, `caption`, `field_name`, `id_parameter`) VALUES (11, 1, 1, 0, 0, 0, 1, 'ygin-invoice', 'id', 'id_invoice', 'ygin-invoice-id-invoice')");
      $this->execute("UPDATE da_object SET sequence = 51 WHERE id_object='ygin-invoice'");
      $this->execute("INSERT INTO `da_object_parameters` (`id_parameter_type`, `sequence`, `not_null`, `need_locale`, `search`, `is_additional`, `visible`, `id_object`, `group_type`, `caption`, `field_name`, `id_parameter`, `widget`, `add_parameter`, `sql_parameter`, `default_value`, `is_unique`, `hint`) VALUES (4, 0, 1, 0, 0, 0, 1, 'ygin-invoice', 0, 'Дата создания', 'create_date', 'ygin-invoice-create-date', NULL, '0', NULL, NULL, 0, '')");
      $this->execute("UPDATE da_object_parameters SET sequence = 293 WHERE id_parameter='ygin-invoice-create-date'");
      $this->execute("INSERT INTO `da_object_parameters` (`id_parameter_type`, `sequence`, `not_null`, `need_locale`, `search`, `is_additional`, `visible`, `id_object`, `group_type`, `caption`, `field_name`, `id_parameter`, `widget`, `add_parameter`, `sql_parameter`, `default_value`, `is_unique`, `hint`) VALUES (4, 0, 0, 0, 0, 0, 1, 'ygin-invoice', 0, 'Дата оплаты', 'pay_date', 'ygin-invoice-pay-date', NULL, '0', NULL, NULL, 0, '')");
      $this->execute("UPDATE da_object_parameters SET sequence = 294 WHERE id_parameter='ygin-invoice-pay-date'");
      $this->execute("INSERT INTO `da_object_parameters` (`id_parameter_type`, `sequence`, `not_null`, `need_locale`, `search`, `is_additional`, `visible`, `id_object`, `group_type`, `caption`, `field_name`, `id_parameter`, `widget`, `add_parameter`, `sql_parameter`, `default_value`, `is_unique`, `hint`) VALUES (1, 0, 1, 0, 0, 0, 1, 'ygin-invoice', 0, 'Сумма', 'amount', 'ygin-invoice-amount', NULL, NULL, NULL, NULL, 0, '')");
      $this->execute("UPDATE da_object_parameters SET sequence = 295 WHERE id_parameter='ygin-invoice-amount'");
      $this->execute("INSERT INTO `da_object_parameters` (`id_parameter_type`, `sequence`, `not_null`, `need_locale`, `search`, `is_additional`, `visible`, `id_object`, `group_type`, `caption`, `field_name`, `id_parameter`, `widget`, `add_parameter`, `sql_parameter`, `default_value`, `is_unique`, `hint`) VALUES (7, 0, 1, 0, 0, 0, 1, 'ygin-invoice', 0, 'Заказ', 'id_offer', 'ygin-invoice-id-offer', NULL, '519', NULL, NULL, 0, '')");
      $this->execute("UPDATE da_object_parameters SET sequence = 296 WHERE id_parameter='ygin-invoice-id-offer'");
      $this->execute("UPDATE `da_object` SET `id_object`='ygin-invoice', `name`='Счета', `id_field_order`='ygin-invoice-create-date', `order_type`=2, `table_name`='pr_invoice', `id_field_caption`='ygin-invoice-create-date', `object_type`=1, `folder_name`=NULL, `parent_object`='518', `sequence`=51, `use_domain_isolation`=0, `field_caption`='create_date', `yii_model`='Invoice' WHERE `da_object`.`id_object`='ygin-invoice'");
      $this->execute("INSERT INTO `da_auth_item` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('edit_object_ygin-invoice', 0, 'Операция изменения для объекта Счета', NULL, 'N;')");
      $this->execute("INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('dev', 'edit_object_ygin-invoice')");
      $this->execute("INSERT INTO `da_auth_item` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('delete_object_ygin-invoice', 0, 'Операция удаления для объекта Счета', NULL, 'N;')");
      $this->execute("INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('dev', 'delete_object_ygin-invoice')");
      $this->execute("INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('editor', 'edit_object_ygin-invoice')");
      $this->execute("INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('editor', 'delete_object_ygin-invoice')");
      $this->execute("INSERT INTO `da_auth_item` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('list_object_ygin-invoice', 0, 'Просмотр списка данных объекта Счета', NULL, 'N;')");
      $this->execute("INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('dev', 'list_object_ygin-invoice')");
      $this->execute("INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('editor', 'list_object_ygin-invoice')");
      $this->execute("INSERT INTO `da_object_view` (`order_no`, `visible`, `count_data`, `id_object_view`, `name`, `id_object`, `sql_order_by`) VALUES (1, 1, 50, 'ygin-invoice-view-main', 'Счета', 'ygin-invoice', 'create_date DESC')");
      $this->execute("INSERT INTO `da_object_view_column` (`order_no`, `id_data_type`, `visible`, `id_object_view_column`, `id_object_view`, `id_object`, `id_object_parameter`, `caption`, `field_name`) VALUES (1, 4, 1, 'ygin-invoice-view-main-create-date', 'ygin-invoice-view-main', 'ygin-invoice', 'ygin-invoice-create-date', 'Дата создания', 'create_date')");
      $this->execute("INSERT INTO `da_object_view_column` (`order_no`, `id_data_type`, `visible`, `id_object_view_column`, `id_object_view`, `id_object`, `id_object_parameter`, `caption`, `field_name`) VALUES (1, 4, 1, 'ygin-invoice-view-main-pay-date', 'ygin-invoice-view-main', 'ygin-invoice', 'ygin-invoice-pay-date', 'Дата оплаты', 'pay_date')");
      $this->execute("INSERT INTO `da_object_view_column` (`order_no`, `id_data_type`, `visible`, `id_object_view_column`, `id_object_view`, `id_object`, `id_object_parameter`, `caption`, `field_name`) VALUES (1, 1, 1, 'ygin-invoice-view-main-amount', 'ygin-invoice-view-main', 'ygin-invoice', 'ygin-invoice-amount', 'Сумма', 'amount')");
      $this->execute("INSERT INTO `da_object_view_column` (`order_no`, `id_data_type`, `visible`, `id_object_view_column`, `id_object_view`, `id_object`, `id_object_parameter`, `caption`, `field_name`) VALUES (1, 7, 1, 'ygin-invoice-view-main-id-offer', 'ygin-invoice-view-main', 'ygin-invoice', 'ygin-invoice-id-offer', 'Заказ', 'id_offer')");
      $this->execute("INSERT INTO `da_object_parameters` (`id_parameter_type`, `sequence`, `not_null`, `need_locale`, `search`, `is_additional`, `visible`, `id_object`, `group_type`, `caption`, `field_name`, `id_parameter`, `widget`, `add_parameter`, `sql_parameter`, `default_value`, `is_unique`, `hint`) VALUES (1, 0, 1, 0, 0, 0, 1, '519', 0, 'Сумма', 'amount', 'ygin-offer-amount', NULL, NULL, NULL, NULL, 0, '')");
      $this->execute("UPDATE da_object_parameters SET sequence = 297 WHERE id_parameter='ygin-offer-amount'");
      $this->execute("INSERT INTO `da_object_parameters` (`id_parameter_type`, `sequence`, `not_null`, `need_locale`, `search`, `is_additional`, `visible`, `id_object`, `group_type`, `caption`, `field_name`, `id_parameter`, `widget`, `add_parameter`, `sql_parameter`, `default_value`, `is_unique`, `hint`) VALUES (7, 0, 0, 0, 0, 0, 1, '519', 0, 'Счет', 'id_invoice', 'ygin-offer-id-invoice', NULL, 'ygin-invoice', NULL, NULL, 0, '')");
      $this->execute("UPDATE da_object_parameters SET sequence = 298 WHERE id_parameter='ygin-offer-id-invoice'");

      $this->execute("INSERT INTO `da_system_parameter` (`id_system_parameter`, `id_group_system_parameter`, `name`, `value`, `note`, `id_parameter_type`, `long_text_value`) VALUES ('project-parameter-moneta-merchant-login', 2, 'moneta_merchant_login', '123', 'Номер счета в мерчанте монеты', 2, '')");
      $this->execute("INSERT INTO `da_system_parameter` (`id_system_parameter`, `id_group_system_parameter`, `name`, `value`, `note`, `id_parameter_type`, `long_text_value`) VALUES ('project-parameter-moneta-merchant-pass1', 2, 'moneta_merchant_pass1', '123456789', 'Пароль #1 в мерчанте монеты', 2, '')");
      $this->execute("INSERT INTO `da_system_parameter` (`id_system_parameter`, `id_group_system_parameter`, `name`, `value`, `note`, `id_parameter_type`, `long_text_value`) VALUES ('project-parameter-robokassa-merchant-login', 2, 'robokassa_merchant_login', 'sport_taim', 'Логин в мерчанте робокассы', 2, '')");
      $this->execute("INSERT INTO `da_system_parameter` (`id_system_parameter`, `id_group_system_parameter`, `name`, `value`, `note`, `id_parameter_type`, `long_text_value`) VALUES ('project-parameter-robokassa-merchant-pass1', 2, 'robokassa_merchant_pass1', '$p0rtt41m', 'Пароль #1 в мерчанте робокассы', 2, '')");
      $this->execute("INSERT INTO `da_system_parameter` (`id_system_parameter`, `id_group_system_parameter`, `name`, `value`, `note`, `id_parameter_type`, `long_text_value`) VALUES ('project-parameter-robokassa-merchant-pass2', 2, 'robokassa_merchant_pass2', 't41m$p0rt', 'Пароль #2 в мерчанте робокассы', 2, '')");

      $path = dirname(__FILE__)."/../../assets/";
      @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
    }
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
