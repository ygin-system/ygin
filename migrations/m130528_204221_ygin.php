<?php

class m130528_204221_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE `da_object_parameters` SET sql_parameter=NULL WHERE `id_parameter_type`=11");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`='20', `id_parameter`=63, `id_parameter_type`=11, `sequence`=1, `widget`=NULL, `caption`='id', `field_name`='id_object', `add_parameter`='1', `default_value`=NULL, `not_null`=1, `sql_parameter`=NULL, `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='Уникальный ИД объекта в виде строки. Например для новостей ИД будет равен ygin.news  Вместо ygin можно использовать название проекта или компании.' WHERE `da_object_parameters`.`id_object`='20' AND `da_object_parameters`.`id_parameter`=63");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`='21', `id_parameter`='74', `id_parameter_type`=11, `sequence`=4, `widget`=NULL, `caption`='id', `field_name`='id_parameter', `add_parameter`='1', `default_value`=NULL, `not_null`=1, `sql_parameter`=NULL, `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='Уникальный ИД свойства объекта в виде строки. Например для заголовка новостей ИД будет равен ygin.news.title  Вместо ygin можно использовать название проекта или компании.' WHERE `da_object_parameters`.`id_object`='21' AND `da_object_parameters`.`id_parameter`='74'");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=2 WHERE `da_object_parameters`.`id_object`='63' AND `da_object_parameters`.`id_parameter`='410'");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=3 WHERE `da_object_parameters`.`id_object`='63' AND `da_object_parameters`.`id_parameter`='411'");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=4 WHERE `da_object_parameters`.`id_object`='63' AND `da_object_parameters`.`id_parameter`='401'");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=5 WHERE `da_object_parameters`.`id_object`='63' AND `da_object_parameters`.`id_parameter`='406'");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=6 WHERE `da_object_parameters`.`id_object`='63' AND `da_object_parameters`.`id_parameter`='408'");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=7 WHERE `da_object_parameters`.`id_object`='63' AND `da_object_parameters`.`id_parameter`='409'");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=8 WHERE `da_object_parameters`.`id_object`='63' AND `da_object_parameters`.`id_parameter`='402'");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=9 WHERE `da_object_parameters`.`id_object`='63' AND `da_object_parameters`.`id_parameter`='403'");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=10 WHERE `da_object_parameters`.`id_object`='63' AND `da_object_parameters`.`id_parameter`='404'");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=11 WHERE `da_object_parameters`.`id_object`='63' AND `da_object_parameters`.`id_parameter`='405'");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=12 WHERE `da_object_parameters`.`id_object`='63' AND `da_object_parameters`.`id_parameter`='407'");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`='63', `id_parameter`='400', `id_parameter_type`=11, `sequence`=1, `widget`=NULL, `caption`='id', `field_name`='id_object_view', `add_parameter`='1', `default_value`=NULL, `not_null`=1, `sql_parameter`=NULL, `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='Уникальный ИД представления объекта в виде строки. Обычно имеет имя ygin.news.view.main  Вместо ygin можно использовать название проекта или компании' WHERE `da_object_parameters`.`id_object`='63' AND `da_object_parameters`.`id_parameter`='400'");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`='66', `id_parameter`='415', `id_parameter_type`=11, `sequence`=1, `widget`=NULL, `caption`='id', `field_name`='id_object_view_column', `add_parameter`='1', `default_value`=NULL, `not_null`=1, `sql_parameter`=NULL, `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='Уникальный ИД колонки представления. Например для заголовка новости ИД будет равен ygin.news.view.main.title  Вместо ygin можно использовать название проекта или компании.' WHERE `da_object_parameters`.`id_object`='66' AND `da_object_parameters`.`id_parameter`='415'");
    $this->execute("UPDATE `da_object` SET `id_object`='52', `name`='Параметры планировщика', `id_field_order`='', `order_type`=1, `table_name`='da_job_parameter_value', `id_field_caption`='', `object_type`=1, `folder_name`=NULL, `parent_object`=51, `sequence`=15, `use_domain_isolation`=0, `field_caption`=NULL, `yii_model`=NULL WHERE `da_object`.`id_object`='52'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='278'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`='52' AND `da_object_parameters`.`id_parameter`='278'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='279'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`='52' AND `da_object_parameters`.`id_parameter`='279'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='280'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`='52' AND `da_object_parameters`.`id_parameter`='280'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=21 AND id_instance='277'");
    $this->execute("DELETE FROM `da_object_parameters` WHERE `da_object_parameters`.`id_object`='52' AND `da_object_parameters`.`id_parameter`='277'");
    $this->execute("DELETE FROM da_domain_object WHERE id_object = '52'");
    $this->execute("DELETE FROM da_search_data WHERE id_object=20 AND id_instance='52'");
    $this->execute("DELETE FROM `da_object` WHERE `da_object`.`id_object`='52'");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=1 WHERE `da_object_parameters`.`id_object`='51' AND `da_object_parameters`.`id_parameter`='267'");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=2 WHERE `da_object_parameters`.`id_object`='51' AND `da_object_parameters`.`id_parameter`='274'");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=3 WHERE `da_object_parameters`.`id_object`='51' AND `da_object_parameters`.`id_parameter`='291'");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=10 WHERE `da_object_parameters`.`id_object`='51' AND `da_object_parameters`.`id_parameter`='276'");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=11 WHERE `da_object_parameters`.`id_object`='51' AND `da_object_parameters`.`id_parameter`='300'");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=12 WHERE `da_object_parameters`.`id_object`='51' AND `da_object_parameters`.`id_parameter`='301'");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=13 WHERE `da_object_parameters`.`id_object`='51' AND `da_object_parameters`.`id_parameter`='302'");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`='51', `id_parameter`='267', `id_parameter_type`=11, `sequence`=1, `widget`=NULL, `caption`='id', `field_name`='id_job', `add_parameter`='1', `default_value`=NULL, `not_null`=1, `sql_parameter`=NULL, `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='Уникальный ИД задачи планировщика. Например для отправки уведомлений это будет ygin.send_mail  Вместо ygin можно использовать название проекта или компании.' WHERE `da_object_parameters`.`id_object`='51' AND `da_object_parameters`.`id_parameter`='267'");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=1 WHERE `da_object_parameters`.`id_object`='80' AND `da_object_parameters`.`id_parameter`='338'");
    $this->execute("UPDATE `da_object_parameters` SET `sequence`=2 WHERE `da_object_parameters`.`id_object`='80' AND `da_object_parameters`.`id_parameter`='337'");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`='80', `id_parameter`='338', `id_parameter_type`=11, `sequence`=1, `widget`=NULL, `caption`='id', `field_name`='id_php_script_type', `add_parameter`='1', `default_value`=NULL, `not_null`=1, `sql_parameter`=NULL, `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='Уникальный ИД пхп обработчика. Например для модуля новостей это будет ygin.news.module.last  Вместо ygin можно использовать название проекта или компании.' WHERE `da_object_parameters`.`id_object`='80' AND `da_object_parameters`.`id_parameter`='338'");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`='30', `id_parameter`='116', `id_parameter_type`=11, `sequence`=8, `widget`=NULL, `caption`='id', `field_name`='id_system_parameter', `add_parameter`='1', `default_value`=NULL, `not_null`=1, `sql_parameter`=NULL, `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='Уникальный ИД системного параметра. Например ygin.parameter.phone  Вместо ygin можно использовать название проекта или компании.' WHERE `da_object_parameters`.`id_object`='30' AND `da_object_parameters`.`id_parameter`='116'");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`='27', `id_parameter`='109', `id_parameter_type`=11, `sequence`=8, `widget`=NULL, `caption`='id', `field_name`='id_reference', `add_parameter`='1', `default_value`=NULL, `not_null`=1, `sql_parameter`=NULL, `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='' WHERE `da_object_parameters`.`id_object`='27' AND `da_object_parameters`.`id_parameter`='109'");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`='28', `id_parameter`='111', `id_parameter_type`=11, `sequence`=1, `widget`=NULL, `caption`='id', `field_name`='id_reference_element_instance', `add_parameter`='1', `default_value`=NULL, `not_null`=1, `sql_parameter`=NULL, `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='Уникальный ИД элемента справочника. Например ygin.shop.reference.order_status.new  Вместо ygin можно использовать название проекта или компании.' WHERE `da_object_parameters`.`id_object`='28' AND `da_object_parameters`.`id_parameter`='111'");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
