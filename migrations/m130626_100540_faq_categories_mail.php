<?php
  class m130626_100540_faq_categories_mail extends CDbMigration {
    public function safeUp() {
      $this->execute("INSERT INTO `da_references` (`id_reference`, `name`) VALUES ('ygin-faq-reference-categoryQuestion', 'Категории вопросов')");
      $this->execute("INSERT INTO `da_reference_element` (`id_reference`, `id_reference_element`, `id_reference_element_instance`, `value`, `image_element`) VALUES ('ygin-faq-reference-categoryQuestion', 1, 'ygin-faq-reference-categoryQuestion-general', 'Общие', NULL)");
      $this->execute("INSERT INTO `da_reference_element` (`id_reference`, `id_reference_element`, `id_reference_element_instance`, `value`, `image_element`) VALUES ('ygin-faq-reference-categoryQuestion', 2, 'ygin-faq-reference-categoryQuestion-personal', 'Личные', NULL)");
      $this->execute("INSERT INTO `da_object_parameters` (`id_parameter_type`, `sequence`, `not_null`, `need_locale`, `search`, `is_additional`, `id_object`, `group_type`, `caption`, `field_name`, `id_parameter`, `widget`, `add_parameter`, `sql_parameter`, `default_value`, `is_unique`, `hint`) VALUES (6, 0, 1, 0, 0, 0, '512', 0, 'Категория', 'category', 'ygin-faq-category', NULL, 'ygin-faq-reference-categoryQuestion', NULL, '1', 0, '')");
      $this->execute("ALTER TABLE `pr_question` ADD `category` INT(8) NOT NULL default '1' COMMENT  'Категория'");
      $this->execute("INSERT INTO `da_object_view_column` (`order_no`, `id_data_type`, `visible`, `id_object_view`, `id_object_view_column`, `id_object`, `caption`, `id_object_parameter`, `field_name`, `handler`) VALUES (0, 6, 1, '2011', 'ygin-faq-view-categoryQuestion', '512', 'Категория', 'ygin-faq-category', 'category', '')");
      $this->execute("INSERT INTO `da_object_parameters` (`id_parameter_type`, `sequence`, `not_null`, `need_locale`, `search`, `is_additional`, `id_object`, `group_type`, `caption`, `field_name`, `id_parameter`, `widget`, `add_parameter`, `sql_parameter`, `default_value`, `is_unique`, `hint`) VALUES (9, 0, 1, 0, 0, 0, '512', 0, 'Отправить ответ на email', 'send', 'ygin-faq-send', NULL, NULL, NULL, '0', 0, '')");
      $this->execute("ALTER TABLE `pr_question` ADD `send` TINYINT(1) NOT NULL default '0' COMMENT  'Отправить ответ на email'");
      $path = dirname(__FILE__)."/../../assets/";
      @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
    }

    public function safeDown() {
      echo get_class($this)." does not support migration down.\n";
      return false;
    }
  }