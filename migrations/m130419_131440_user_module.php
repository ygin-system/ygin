<?php

class m130419_131440_user_module extends CDbMigration
{


  public function down()
  {
    echo "m130419_131440_user_module does not support migration down.\n";
    return false;
  }


  // Use safeUp/safeDown to do migration with transaction
  public function safeUp()
  {
    Yii::app()->attachEventHandler('onEndRequest', array($this, 'updatePlugin'));
    $this->execute(" INSERT INTO `da_object_parameters` (`id_parameter`, `id_parameter_type`, `caption`, `id_object`, `sequence`, `name`, `field_name`, `add_parameter`, `sql_parameter`, `default_value`, `not_null`, `need_locale`, `search`, `group_type`, `is_additional`, `hint`, `is_unique`) VALUES (1697, 9, 'Необходимо сменить пароль', 24, 0, 'requires_new_password', 'requires_new_password', NULL, NULL, NULL, 0, 0, 0, 0, 1, NULL, 0);");
    $this->execute("ALTER TABLE `da_users` ADD `requires_new_password` TINYINT(1) COMMENT  'Необходимо сменить пароль';");
    $this->execute("ALTER TABLE  `da_users` ADD  `salt` VARCHAR( 255 ) NULL COMMENT  'Соль для пароля',
    ADD  `password_strategy` VARCHAR( 255 ) NULL COMMENT  'Стратегия для формирования пароля';");
    $this->execute("UPDATE `da_users` SET `password_strategy` = 'legacy';");
    $this->execute("ALTER TABLE  `da_users` CHANGE  `requires_new_password`  `requires_new_password` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  'Необходимо сменить пароль';");
  }
  public function updatePlugin(CEvent $event) {
    Yii::import('ygin.modules.mail.models.*', true);
    Yii::import('ygin.modules.menu.models.*', true);
    Yii::import('ygin.modules.backend.modules.plugin.PluginModule', true);
    PluginModule::updateByCode('ygin.cabinet');
  }
}