<?php

class m121018_062954_photogallery_module extends CDbMigration
{
	
	public function down()
	{
		echo "m121018_062954_photogallery_module does not support migration down.\n";
		return false;
	}

	
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
    Yii::app()->attachEventHandler('onEndRequest', array($this, 'updatePlugin'));
	}

  public function updatePlugin(CEvent $event) {
    Yii::import('ygin.modules.menu.models.*', true);
    Yii::import('ygin.modules.backend.modules.plugin.PluginModule', true);
    PluginModule::updateByCode('ygin.photogallery');
  }

}