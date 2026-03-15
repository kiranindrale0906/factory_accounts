<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_user_activities extends CI_Model {

  public function up()
  {
    $sql = "CREATE TABLE IF NOT EXISTS `user_activities` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `category` VARCHAR(255) NOT NULL,
            `action` VARCHAR(255) NOT NULL,
            `label` VARCHAR(255) NULL,
            `value` VARCHAR(255) NULL,
            `user_id` INT(11) NULL,
            `session_id` VARCHAR(255) NOT NULL,
            `created_by` INT(11) NULL,
            `updated_by` INT(11) NULL,
            `created_at` DATETIME NULL,
            `updated_at` DATETIME NULL,
            `is_delete` TINYINT(4) NULL DEFAULT 0,
            PRIMARY KEY (`id`)
            ) ENGINE = InnoDB;";
    $this->db->query($sql);
  }
}
?>