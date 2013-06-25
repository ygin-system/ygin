<?php

class m130614_131857_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE `da_object_parameters` SET `id_object`='105', `id_parameter`='532', `id_parameter_type`=10, `sequence`=7, `widget`='vote.backend.widgets.answerList.AnswerListWidget', `caption`='Варианты ответов', `field_name`=NULL, `add_parameter`='2', `default_value`=NULL, `not_null`=0, `sql_parameter`='VoteAnswerVisualElement', `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='' WHERE `da_object_parameters`.`id_object`='105' AND `da_object_parameters`.`id_parameter`='532'");
    $this->execute("UPDATE `da_object` SET `yii_model`='vote.models.Voting' WHERE `da_object`.`id_object`='105'");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
