<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_all_users_data extends CI_Model {

  public function up()
  {
  	$sql = "CREATE TABLE IF NOT EXISTS `users` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(50) NOT NULL,
            `email_id` varchar(255) DEFAULT NULL,
            `encrypted_password` varchar(255) DEFAULT NULL,
            `mobile_no` varchar(255) NOT NULL,
            `reset_token` varchar(255) DEFAULT NULL,
            `status` varchar(255) NOT NULL,
            `last_sign_in_at` datetime DEFAULT NULL,
            `last_sign_in_ip` varchar(255) DEFAULT NULL,
            `created_at` datetime NOT NULL,
            `updated_at` datetime NOT NULL,
            `password_updated_at` datetime NOT NULL,
            `is_delete` tinyint(4) DEFAULT '0',
            `created_by` int(11) DEFAULT NULL,
            `updated_by` int(11) DEFAULT NULL,
            `last_read_notification` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
            `google_access_token` varchar(255) DEFAULT NULL,
            `linkedin_access_token` varchar(255) DEFAULT NULL,
            `email_verified` varchar(255) DEFAULT NULL,
            `mobile_verified` varchar(255) DEFAULT NULL,
            `email_verify_code` varchar(20) DEFAULT NULL,
            `mobile_verify_code` int(6) DEFAULT NULL,
            `email_sent_at` datetime DEFAULT NULL,
            `sms_sent_at` datetime DEFAULT NULL,
            `facebook_access_token` varchar(255) DEFAULT NULL,
            `twitter_access_token` varchar(255) DEFAULT NULL,
            `slack_access_token` varchar(255) DEFAULT NULL,
            `slack_user_id` varchar(25) DEFAULT NULL,
            `slack_user_name` varchar(50) DEFAULT NULL,
            `slack_workspace_id` varchar(25) DEFAULT NULL,
            `slack_workspace_name` varchar(50) DEFAULT NULL,
            `slack_workspace_domain` varchar(255) DEFAULT NULL,
            `access_token` varchar(255) DEFAULT NULL,
            `is_email_verify` tinyint(4) NOT NULL DEFAULT '0',
            `mobile_verify_otp` int(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;";
    $this->db->query($sql);
  }


}

?>