SET foreign_key_checks = 0;

ALTER TABLE `da_auth_assignment`
  ADD CONSTRAINT `da_auth_assignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `da_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `da_auth_item_child`
  ADD CONSTRAINT `da_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `da_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `da_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `da_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;
