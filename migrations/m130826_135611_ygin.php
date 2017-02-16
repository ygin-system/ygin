<?php

class m130826_135611_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("INSERT INTO `da_object_parameters` (`id_parameter_type`, `sequence`, `not_null`, `need_locale`, `search`, `is_additional`, `id_object`, `group_type`, `caption`, `field_name`, `id_parameter`, `widget`, `add_parameter`, `sql_parameter`, `default_value`, `is_unique`, `hint`) VALUES (9, 0, 1, 0, 0, 0, '21', 0, 'Видимость', 'visible', 'ygin-object-parameter-visible', NULL, NULL, NULL, '1', 0, 'Доступно ли свойство при редактировании экземпляра объекта')");
    $this->execute("UPDATE da_object_parameters SET sequence = 288 WHERE id_parameter='ygin-object-parameter-visible'");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
