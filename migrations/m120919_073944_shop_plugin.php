<?php

class m120919_073944_shop_plugin extends CDbMigration
{
  public function up()
  {

    Yii::import('ygin.modules.backend.modules.plugin.PluginModule', true);
    PluginModule::updateByCode('ygin.shop');

  }

  public function down()
  {
    echo "m120919_073944_shop_module does not support migration down.\n";
    return false;
  }

  /*
  // Use safeUp/safeDown to do migration with transaction
  public function safeUp()
  {
  }

  public function safeDown()
  {
  }
  */
}