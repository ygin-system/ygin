<?php

class m140108_191559_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE `da_object_view` SET `icon_class`='glyphicon glyphicon-list-alt' WHERE `da_object_view`.`id_object_view`='ygin-menu-view-main'");
    $this->execute("UPDATE `da_object_view` SET `icon_class`='glyphicon glyphicon-bullhorn' WHERE `da_object_view`.`id_object_view`='2002'");
    $this->execute("UPDATE `da_object_view` SET `icon_class`='glyphicon glyphicon-picture' WHERE `da_object_view`.`id_object_view`='2000'");
    $this->execute("UPDATE `da_object_view` SET `icon_class`='glyphicon glyphicon-share-alt' WHERE `da_object_view`.`id_object_view`='2016'");
    $this->execute("UPDATE `da_object_view` SET `icon_class`='glyphicon glyphicon-retweet' WHERE `da_object_view`.`id_object_view`='2011'");
    $this->execute("UPDATE `da_object_view` SET `icon_class`='glyphicon glyphicon-comment' WHERE `da_object_view`.`id_object_view`='67'");
    $this->execute("UPDATE `da_object_view` SET `icon_class`='glyphicon glyphicon-fullscreen' WHERE `da_object_view`.`id_object_view`='2018'");
    $this->execute("UPDATE `da_object_view` SET `icon_class`='glyphicon glyphicon-book' WHERE `da_object_view`.`id_object_view`='2025'");
    $this->execute("UPDATE `da_object_view` SET `icon_class`='glyphicon glyphicon-tags' WHERE `da_object_view`.`id_object_view`='100'");
    $this->execute("UPDATE `da_object_view` SET `icon_class`='glyphicon glyphicon-import' WHERE `da_object_view`.`id_object_view`='100'");
    $this->execute("UPDATE `da_object_view` SET `icon_class`='glyphicon glyphicon-tags' WHERE `da_object_view`.`id_object_view`='55'");
    $this->execute("UPDATE `da_object_view` SET `icon_class`='glyphicon glyphicon-tag' WHERE `da_object_view`.`id_object_view`='57'");
    $this->execute("UPDATE `da_object_view` SET `icon_class`='glyphicon glyphicon-gift' WHERE `da_object_view`.`id_object_view`='2008'");
    $this->execute("UPDATE `da_object_view` SET `icon_class`='glyphicon glyphicon-shopping-cart' WHERE `da_object_view`.`id_object_view`='2017'");
    $this->execute("UPDATE `da_object_view` SET `icon_class`='glyphicon glyphicon-bookmark' WHERE `da_object_view`.`id_object_view`='2023'");
    $this->execute("UPDATE `da_object_view` SET `icon_class`='glyphicon glyphicon-th-large' WHERE `da_object_view`.`id_object_view`='2'");
    $this->execute("UPDATE `da_object_view` SET `icon_class`='glyphicon glyphicon-dashboard' WHERE `da_object_view`.`id_object_view`='33'");
    $this->execute("UPDATE `da_object_view` SET `icon_class`='glyphicon glyphicon-user' WHERE `da_object_view`.`id_object_view`='6'");
    $this->execute("UPDATE `da_object_view` SET `icon_class`='glyphicon glyphicon-pushpin' WHERE `da_object_view`.`id_object_view`='13'");
    $this->execute("UPDATE `da_object_view` SET `icon_class`='glyphicon glyphicon-wrench' WHERE `da_object_view`.`id_object_view`='12'");
    $this->execute("UPDATE `da_object_view` SET `icon_class`='glyphicon glyphicon-calendar' WHERE `da_object_view`.`id_object_view`='33'");
    $this->execute("UPDATE `da_object_view` SET `icon_class`='glyphicon glyphicon-book' WHERE `da_object_view`.`id_object_view`='9'");
    $this->execute("UPDATE `da_object_view` SET `icon_class`='glyphicon glyphicon-inbox' WHERE `da_object_view`.`id_object_view`='32'");
    $this->execute("UPDATE `da_object_view` SET `icon_class`='glyphicon glyphicon-cog' WHERE `da_object_view`.`id_object_view`='12'");
    $this->execute("UPDATE `da_object_view` SET `icon_class`='glyphicon glyphicon-envelope' WHERE `da_object_view`.`id_object_view`='16'");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
