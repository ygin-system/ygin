<?php

class m140208_112056_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE `da_references` SET `id_reference`='33', `name`='Дополнительные варианты обработки контента в разделе' WHERE `da_references`.`id_reference`='33'");
    $this->execute("UPDATE `da_reference_element` SET `id_reference`='33', `id_reference_element`=1, `value`='Отобразить список вложенных разделов при отсутствии контента', `image_element`=NULL, `id_reference_element_instance`='50' WHERE `da_reference_element`.`id_reference_element_instance`='50'");
    $this->execute("UPDATE `da_reference_element` SET `id_reference`='33', `id_reference_element`=2, `value`='Переходить к первому вложенному разделу при отсутствии контента', `image_element`=NULL, `id_reference_element_instance`='51' WHERE `da_reference_element`.`id_reference_element_instance`='51'");
    $this->execute("UPDATE `da_reference_element` SET `id_reference`='33', `id_reference_element`=3, `value`='Открыть первый загруженный файл при отсутствии контента', `image_element`=NULL, `id_reference_element_instance`='52' WHERE `da_reference_element`.`id_reference_element_instance`='52'");
    $this->execute("UPDATE `da_reference_element` SET `id_reference`='33', `id_reference_element`=4, `value`='При отсутствии контента не выводить предупреждение, отобразить пустую страницу', `image_element`=NULL, `id_reference_element_instance`='509' WHERE `da_reference_element`.`id_reference_element_instance`='509'");
    $this->execute("INSERT INTO `da_reference_element` (`id_reference`, `id_reference_element`, `id_reference_element_instance`, `value`, `image_element`) VALUES ('33', 5, 'ygin-menu-content-show-included-items-after-content', 'Вывести список вложенных разделов после контента', NULL)");
    $this->execute("INSERT INTO `da_reference_element` (`id_reference`, `id_reference_element`, `id_reference_element_instance`, `value`, `image_element`) VALUES ('33', 6, 'ygin-menu-content-show-included-items-before-content', 'Вывести список вложенных разделов перед контентом', NULL)");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`='ygin-menu', `id_parameter`='10', `id_parameter_type`=6, `sequence`=12, `widget`=NULL, `caption`='Дополнительные опции обработки контента:', `field_name`='go_to_type', `add_parameter`='33', `default_value`='1', `not_null`=1, `sql_parameter`=NULL, `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='Определяет дополнительные действия для содержимого раздела', `visible`=1 WHERE `da_object_parameters`.`id_object`='ygin-menu' AND `da_object_parameters`.`id_parameter`='10'");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
