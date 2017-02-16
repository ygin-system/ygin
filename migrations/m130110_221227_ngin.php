<?php

class m130110_221227_ngin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE `da_object` SET `id_object`=63, `name`='Представление', `id_field_order`=408, `order_type`=1, `table_name`='da_object_view', `id_field_caption`=406, `object_type`=1, `folder_name`=NULL, `parent_object`=1, `sequence`=8, `seq_start_value`=2000, `use_domain_isolation`=0, `id_object_handler`=NULL, `id_instance_class`=NULL, `field_caption`='name', `yii_model`='ngin.models.object.DaObjectView' WHERE `da_object`.`id_object`=63");
    $this->execute("UPDATE `da_object` SET `id_object`=66, `name`='Колонка представления', `id_field_order`=419, `order_type`=1, `table_name`='da_object_view_column', `id_field_caption`=NULL, `object_type`=1, `folder_name`=NULL, `parent_object`=63, `sequence`=9, `seq_start_value`=6000, `use_domain_isolation`=0, `id_object_handler`=421, `id_instance_class`=NULL, `field_caption`=NULL, `yii_model`='ngin.models.object.DaObjectViewColumn' WHERE `da_object`.`id_object`=66");
    $this->execute("UPDATE `da_object` SET `id_object`=80, `name`='php-скрипты', `id_field_order`=337, `order_type`=1, `table_name`='da_php_script_type', `id_field_caption`=342, `object_type`=1, `folder_name`=NULL, `parent_object`=1, `sequence`=3, `seq_start_value`=1000, `use_domain_isolation`=0, `id_object_handler`=NULL, `id_instance_class`=NULL, `field_caption`='description', `yii_model`='ngin.models.PhpScript' WHERE `da_object`.`id_object`=80");
    $this->execute("UPDATE `da_object` SET `id_object`=27, `name`='Справочники', `id_field_order`=109, `order_type`=1, `table_name`='da_references', `id_field_caption`=110, `object_type`=1, `folder_name`=NULL, `parent_object`=3, `sequence`=8, `seq_start_value`=100, `use_domain_isolation`=0, `id_object_handler`=NULL, `id_instance_class`=NULL, `field_caption`='name', `yii_model`='ngin.models.Reference' WHERE `da_object`.`id_object`=27");
    $this->execute("UPDATE `da_object` SET `id_object`=28, `name`='Значения справочника', `id_field_order`=112, `order_type`=1, `table_name`='da_reference_element', `id_field_caption`=114, `object_type`=1, `folder_name`=NULL, `parent_object`=27, `sequence`=3, `seq_start_value`=500, `use_domain_isolation`=0, `id_object_handler`=NULL, `id_instance_class`=NULL, `field_caption`='value', `yii_model`='ngin.models.ReferenceElement' WHERE `da_object`.`id_object`=28");
    $this->execute("UPDATE `da_object` SET `id_object`=34, `name`='Подписчики на события', `id_field_order`=NULL, `order_type`=2, `table_name`='da_event_subscriber', `id_field_caption`=37, `object_type`=1, `folder_name`=NULL, `parent_object`=6, `sequence`=3, `seq_start_value`=100, `use_domain_isolation`=0, `id_object_handler`=NULL, `id_instance_class`=NULL, `field_caption`='id_event_type', `yii_model`='ngin.modules.mail.models.NotifierEventSubscriber' WHERE `da_object`.`id_object`=34");
    $this->execute("UPDATE `da_object` SET `id_object`=35, `name`='Тип события', `id_field_order`=50, `order_type`=2, `table_name`='da_event_type', `id_field_caption`=51, `object_type`=1, `folder_name`=NULL, `parent_object`=6, `sequence`=3, `seq_start_value`=100, `use_domain_isolation`=0, `id_object_handler`=NULL, `id_instance_class`=NULL, `field_caption`='name', `yii_model`='ngin.modules.mail.models.NotifierEventType' WHERE `da_object`.`id_object`=35");
    $this->execute("UPDATE `da_object` SET `id_object`=51, `name`='Планировщик', `id_field_order`=267, `order_type`=1, `table_name`='da_job', `id_field_caption`=274, `object_type`=1, `folder_name`=NULL, `parent_object`=1, `sequence`=14, `seq_start_value`=100, `use_domain_isolation`=0, `id_object_handler`=NULL, `id_instance_class`=NULL, `field_caption`='name', `yii_model`='ngin.modules.scheduler.models.Job' WHERE `da_object`.`id_object`=51");

    $path = dirname(__FILE__)."/../../assets/";
    HFile::removeDirectoryRecursive($path, false, false, false);
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
