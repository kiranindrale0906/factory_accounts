
--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `encrypted_password` varchar(255) NOT NULL,
  `user_role_id` int(11) NOT NULL,
  `user_role` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `last_sign_in_at` datetime,
  `last_sign_in_ip` varchar(255),
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_email_index` (`email`),
  ADD KEY `user_status_index` (`status`);

-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

ALTER TABLE  `users` ADD  `password_token` VARCHAR( 255 ) NOT NULL AFTER  `last_sign_in_ip` ;

INSERT INTO `users` (`id`, `name`, `email`, `encrypted_password`, `user_role_id`, `user_role`, `status`, `last_sign_in_at`, `last_sign_in_ip`, `password_token`, `created_at`, `updated_at`) VALUES (NULL, 'admin', 'admin@admin.com', 'md5("password")', '1', 'Admin', 'Enabled', '', '', '', '', '');

ALTER TABLE `users` add account_id INT(11) NOT NULL;

alter table users add username varchar(255) NOT NULL;
alter table users add mobile_no varchar(255) NOT NULL;
alter table users add salutation varchar(255) NOT NULL;
alter table users add last_name varchar(255) NOT NULL;
alter table users add location varchar(255) NOT NULL;
alter table users add designation varchar(255) NOT NULL;
alter table users add parent_id int(11) NOT NULL;

alter table users add all_legislations tinyint;
alter table users add all_entities tinyint;

ALTER TABLE `users` DROP `user_role_id` ;

alter table users add password varchar(50) NOT NULL;