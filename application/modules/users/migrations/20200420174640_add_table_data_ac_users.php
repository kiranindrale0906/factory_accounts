<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_table_data_ac_users extends CI_Model {

  public function up()
  {
  	$sql = "INSERT INTO `ac_users` (`id`, `username`, `email_id`, `password`, `encrypted_id`, `role`, `department_id`, `created_at`, `updated_at`, `name`, `last_name`, `status`, `branch_id`, `is_delete`, `created_by`, `updated_by`, `last_sign_in_at`, `last_sign_in_ip`, `mobile_no`) VALUES (1, NULL, 'pradeep.kotiyan@gmail.com ', '81dc9bdb52d04dc20036dbd8313ed055', NULL, NULL, 0, '2020-03-02 19:39:20', '2020-03-02 20:23:30', 'Admin', NULL, NULL, 0, 0, NULL, 0, '2020-03-02 19:40:08', '122.169.109.214', '9028448174'),
        (2, NULL, 'admin@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', NULL, NULL, 0, '2020-03-02 19:40:50', '2020-04-20 16:01:05', 'Admin', NULL, NULL, 0, 0, 1, 0, '2020-04-20 16:01:05', '::1', '7889954555');";
    //$this->db->query($sql);
  }


}

?>