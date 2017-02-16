<?php

class m120915_223619_ngin extends CDbMigration {
  public function up() {
    $this->execute("
UPDATE da_site_module SET name = '2Gis-карта', is_visible = '1', link = NULL, content = '<script charset=\"utf-8\" type=\"text/javascript\" src=\"http://firmsonmap.api.2gis.ru/js/DGWidgetLoader.js\"></script>\r\n<script charset=\"utf-8\" type=\"text/javascript\">new DGWidgetLoader({\"borderColor\":\"#a3a3a3\",\"width\":\"770\",\"height\":\"350\",\"wid\":\"47c4edf7e203ee08320f901da417d96a\",\"pos\":{\"lon\":\"50.825820502302\",\"lat\":\"61.668363228081\",\"zoom\":\"17\"},\"opt\":{\"ref\":\"hidden\",\"card\":[\"name\",\"contacts\"],\"city\":\"syktyvkar\"},\"org\":[{\"id\":\"10133627442576620\"}]});</script>\r\n<noscript style=\"color:#c00;font-size:16px;font-weight:bold;\">Виджет карты использует JavaScript. Включите его в настройках вашего браузера.</noscript>', html = NULL, directory = NULL WHERE id_module=116;
");
  }
  
  public function down() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }

  /*
  public function safeUp() {
  }
  public function safeDown() {
  }
  */
}
