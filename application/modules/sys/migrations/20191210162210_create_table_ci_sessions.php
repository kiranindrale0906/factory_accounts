<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_ci_sessions extends CI_Model {

  public function up()
  {
    $sql = 'CREATE TABLE IF NOT EXISTS `ci_sessions` (
        `id` varchar(128) NOT NULL,
        `user_id` int(11) NULL,
        `ip_address` varchar(45) NOT NULL,
        `timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
        `data` blob NOT NULL,
        `created_at` datetime NOT NULL,
        `updated_at` datetime NOT NULL,
        `is_delete` tinyint(4) NOT NULL,
        KEY `ci_sessions_timestamp` (`timestamp`));';

    $this->db->query($sql);
  }


}

?>