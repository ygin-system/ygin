<?php

class m120718_122532_macro extends CDbMigration {
  public function up() {
    $this->execute("CREATE TABLE IF NOT EXISTS `da_auth_assignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `da_auth_assignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('dev', '1', NULL, 'N;'),
('dev', '39', NULL, 'N;'),
('dev', '52', NULL, 'N;'),
('dev', '53', NULL, 'N;'),
('dev', '55', NULL, 'N;'),
('dev', '57', NULL, 'N;'),
('editor', '46', NULL, 'N;'),
('editor', '99', NULL, 'N;');

CREATE TABLE IF NOT EXISTS `da_auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `da_auth_item` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('dev', 2, 'Разработчик', NULL, 'N;'),
('editor', 2, 'Редактор', NULL, 'N;'),
('guest', 2, 'Гость', NULL, 'N;'),
('showAdminPanel', 0, 'доступ к админке', NULL, 'N;');

CREATE TABLE IF NOT EXISTS `da_auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES
('dev', 'editor'),
('editor', 'guest'),
('editor', 'showAdminPanel');

ALTER TABLE `da_auth_assignment`
  ADD CONSTRAINT `da_auth_assignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `da_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `da_auth_item_child`
  ADD CONSTRAINT `da_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `da_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `da_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `da_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;


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
