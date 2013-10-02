<?php

class m131002_193452_banner_module_aggregate_job extends CDbMigration
{

	public function down()
	{
		echo "m131002_193452_banner_module_aggregate_job does not support migration down.\n";
		return false;
	}


	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
    Yii::app()->attachEventHandler('onEndRequest', array($this, 'updatePlugin'));
	}

  public function updatePlugin(CEvent $event) {
    Yii::import('ygin.modules.mail.models.*', true);
    Yii::import('ygin.modules.menu.models.*', true);
    Yii::import('ygin.modules.backend.modules.plugin.PluginModule', true);
    PluginModule::updateByCode('ygin.banners');
  }

}