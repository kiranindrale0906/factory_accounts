CREATE TABLE `users_user_roles` (
  `user_id` int(11) NOT NULL,
  `user_role_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
