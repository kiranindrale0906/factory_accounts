CREATE TABLE IF NOT EXISTS `user_role_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_role_id` int(11) NOT NULL,
  `controller_name` varchar(255) NOT NULL,
  `index` boolean NOT NULL default 0,
  `create` boolean NOT NULL default 0,
  `update` boolean NOT NULL default 0,
  `view` boolean NOT NULL default 0,
  `delete` boolean NOT NULL default 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE  `user_role_permissions` CHANGE  `update`  `edit` TINYINT( 1 ) NOT NULL DEFAULT  '0';