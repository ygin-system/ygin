<?php

  class m140430_115900_ygin extends CDbMigration {
    public function safeUp() {

      $this->execute("
        INSERT INTO `da_object` (`order_type`, `object_type`, `sequence`, `use_domain_isolation`, `parent_object`, `name`, `table_name`, `folder_name`, `field_caption`, `id_field_caption`, `id_field_order`, `yii_model`, `id_object`) VALUES (1, 3, 0, 0, '1', 'Генерация вьюхи', 'ygin.modules.viewGenerator.controllers.DefaultController', NULL, NULL, '', '', NULL, 'ygin-views-generator');
        DELETE FROM `da_auth_item` WHERE name='list_object_';
        INSERT INTO `da_auth_item` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('view_object_ygin-views-generator', 0, 'Операция просмотра для объекта Генерация вьюхи', NULL, 'N;');
        INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('dev', 'view_object_ygin-views-generator');
        INSERT INTO `da_auth_item` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('edit_object_ygin-views-generator', 0, 'Операция изменения для объекта Генерация вьюхи', NULL, 'N;');
        INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('dev', 'edit_object_ygin-views-generator');
        INSERT INTO `da_auth_item` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('delete_object_ygin-views-generator', 0, 'Операция удаления для объекта Генерация вьюхи', NULL, 'N;');
        INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('dev', 'delete_object_ygin-views-generator');
        INSERT INTO `da_auth_item` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('create_object_ygin-views-generator', 0, 'Операция создания для объекта Генерация вьюхи', NULL, 'N;');
        INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('dev', 'create_object_ygin-views-generator');
        INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('editor', 'view_object_ygin-views-generator');
        INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('editor', 'edit_object_ygin-views-generator');
        INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('editor', 'delete_object_ygin-views-generator');
        INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('editor', 'create_object_ygin-views-generator');
        INSERT INTO `da_auth_item` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('list_object_ygin-views-generator', 0, 'Просмотр списка данных объекта Генерация вьюхи', NULL, 'N;');
        INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('dev', 'list_object_ygin-views-generator');
        INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES ('editor', 'list_object_ygin-views-generator');
        UPDATE da_object SET sequence = 50 WHERE id_object='ygin-views-generator';
      ");

      $this->execute("
        UPDATE `da_object` SET `id_object`='ygin-views-generator', `name`='Генерация вьюхи', `id_field_order`='', `order_type`=1, `table_name`='viewGenerator/default/index', `id_field_caption`='', `object_type`=3, `folder_name`=NULL, `parent_object`='1', `sequence`=50, `use_domain_isolation`=0, `field_caption`=NULL, `yii_model`=NULL WHERE `da_object`.`id_object`='ygin-views-generator';
        UPDATE `da_object` SET `id_object`='ygin-views-generator', `name`='Генерация вьюхи', `id_field_order`='', `order_type`=1, `table_name`='/viewGenerator/default/index', `id_field_caption`='', `object_type`=3, `folder_name`=NULL, `parent_object`='1', `sequence`=50, `use_domain_isolation`=0, `field_caption`=NULL, `yii_model`=NULL WHERE `da_object`.`id_object`='ygin-views-generator';
        UPDATE `da_object` SET `id_object`='ygin-views-generator', `name`='Генерация вьюхи', `id_field_order`='', `order_type`=1, `table_name`='viewGenerator/default/index', `id_field_caption`='', `object_type`=3, `folder_name`=NULL, `parent_object`='1', `sequence`=50, `use_domain_isolation`=0, `field_caption`=NULL, `yii_model`=NULL WHERE `da_object`.`id_object`='ygin-views-generator';
        UPDATE `da_object` SET `id_object`='ygin-views-generator', `name`='Генерация вьюхи', `id_field_order`='', `order_type`=1, `table_name`='viewGenerator/default/index', `id_field_caption`='', `object_type`=5, `folder_name`=NULL, `parent_object`='1', `sequence`=50, `use_domain_isolation`=0, `field_caption`=NULL, `yii_model`=NULL WHERE `da_object`.`id_object`='ygin-views-generator';
        UPDATE `da_object` SET `id_object`='ygin-views-generator', `name`='Генерация вьюхи', `id_field_order`='', `order_type`=1, `table_name`='/viewGenerator/default/index', `id_field_caption`='', `object_type`=5, `folder_name`=NULL, `parent_object`='1', `sequence`=50, `use_domain_isolation`=0, `field_caption`=NULL, `yii_model`=NULL WHERE `da_object`.`id_object`='ygin-views-generator';
        UPDATE `da_object` SET `id_object`='ygin-views-generator', `name`='Генерация вьюхи', `id_field_order`='', `order_type`=1, `table_name`='viewGenerator/default/index', `id_field_caption`='', `object_type`=3, `folder_name`=NULL, `parent_object`='1', `sequence`=50, `use_domain_isolation`=0, `field_caption`=NULL, `yii_model`=NULL WHERE `da_object`.`id_object`='ygin-views-generator';
      ");
    }

    public function safeDown() {
      echo get_class($this)." does not support migration down.\n";
      return false;
    }
  }
