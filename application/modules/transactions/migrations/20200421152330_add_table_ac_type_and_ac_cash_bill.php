<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_table_ac_type_and_ac_cash_bill extends CI_Model {

  public function up()
  {
    $this->db->query("CREATE TABLE IF NOT EXISTS `ac_cash_bill` (
					  `id` int(11) NOT NULL,
					  `name` varchar(225) NOT NULL,
					  `created_at` datetime NOT NULL,
					  `created_by` int(11) NOT NULL,
					  `updated_at` datetime NOT NULL,
					  `updated_by` int(11) NOT NULL
					) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    $this->db->query("INSERT INTO `ac_cash_bill` (`id`, `name`, `created_at`, `created_by`,
    			    `updated_at`, `updated_by`) VALUES
					(1, 'Cash', '2020-04-21 00:00:00', 1, '2020-04-21 00:00:00', 1),
					(2, 'Bill', '2020-04-21 00:00:00', 1, '2020-04-21 00:00:00', 1);");
	$this->db->query("ALTER TABLE `ac_cash_bill` ADD PRIMARY KEY (`id`);");
	
/*---------------------------------------------------------------------------------*/

	$this->db->query("CREATE TABLE IF NOT EXISTS `ac_type` (
				  `id` int(11) NOT NULL,
				  `name` varchar(225) NOT NULL,
				  `created_at` datetime NOT NULL,
				  `created_by` int(11) NOT NULL,
				  `updated_at` datetime NOT NULL,
				  `updated_by` int(11) NOT NULL
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;
				");
    $this->db->query("INSERT INTO `ac_type` (`id`, `name`, `created_at`, `created_by`,
    				 `updated_at`, `updated_by`) VALUES
					(1, 'Value', '2020-04-21 00:00:00', 1, '2020-04-21 00:00:00', 1),
					(2, 'Weight', '2020-04-21 00:00:00', 1, '2020-04-21 00:00:00', 1),
					(3, 'Value & Weight', '2020-04-21 00:00:00', 1, '2020-04-21 00:00:00', 1);
					");
	$this->db->query("ALTER TABLE `ac_type` ADD PRIMARY KEY (`id`);");
  }


}

?>
