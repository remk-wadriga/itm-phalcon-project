CREATE TABLE `note` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `name` varchar(128) NOT NULL,
  `text` text NOT NULL,
  `date` datetime NOT NULL,
  `position` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `note_user_id` (`user_id`),
  CONSTRAINT `note_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
