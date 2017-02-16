<?php

class m130515_142007_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE `da_object_parameters` SET `id_object`=31, `id_parameter`=286, `id_parameter_type`=10, `sequence`=8, `name`='yiigin.yiigin.domain.DomainLocalizationVisualElement', `caption`='Доступные локализации', `field_name`='yiigin.yiigin.domain.DomainLocalizationVisualElement', `add_parameter`=2, `default_value`='', `not_null`=0, `sql_parameter`='DomainLocalizationVisualElement', `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='' WHERE `da_object_parameters`.`id_object`=31 AND `da_object_parameters`.`id_parameter`=286");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`=20, `id_parameter`=62, `id_parameter_type`=10, `sequence`=15, `name`='representation', `caption`='Создать представление', `field_name`='yiigin.yiigin.object.objectManageView.ObjectManageViewWidget', `add_parameter`=2, `default_value`='', `not_null`=0, `sql_parameter`='ObjectManageViewWidget', `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=1, `hint`='' WHERE `da_object_parameters`.`id_object`=20 AND `da_object_parameters`.`id_parameter`=62");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`=20, `id_parameter`=151, `id_parameter_type`=10, `sequence`=19, `name`='perm', `caption`='Права доступа', `field_name`='yiigin.yiigin.object.objectPermission.ObjectPermissionWidget', `add_parameter`=2, `default_value`='', `not_null`=0, `sql_parameter`='ObjectPermissionWidget', `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='' WHERE `da_object_parameters`.`id_object`=20 AND `da_object_parameters`.`id_parameter`=151");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`=21, `id_parameter`=76, `id_parameter_type`=7, `sequence`=1, `name`='yiigin.yiigin.objectParameter.typeObjectParameterWidget.TypeObjectParameterWidget', `caption`='Тип свойства', `field_name`='id_parameter_type', `add_parameter`=22, `default_value`='2', `not_null`=1, `sql_parameter`='', `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='' WHERE `da_object_parameters`.`id_object`=21 AND `da_object_parameters`.`id_parameter`=76");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`=66, `id_parameter`=420, `id_parameter_type`=7, `sequence`=7, `name`='yiigin.yiigin.objectParameter.selectObjectParameterWidget.SelectObjectParameterWidget', `caption`='Параметр объекта', `field_name`='id_object_parameter', `add_parameter`=21, `default_value`='', `not_null`=0, `sql_parameter`='', `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='' WHERE `da_object_parameters`.`id_object`=66 AND `da_object_parameters`.`id_parameter`=420");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
