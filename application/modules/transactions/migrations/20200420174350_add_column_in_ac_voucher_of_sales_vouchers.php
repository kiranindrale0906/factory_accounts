<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_in_ac_voucher_of_sales_vouchers extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `ac_vouchers` ADD `cash_bill` DECIMAL(10,4) NOT NULL;");
    $this->db->query("ALTER TABLE `ac_vouchers` ADD `gst_number` decimal(10,4) NOT NULL;");
    $this->db->query("ALTER TABLE `ac_vouchers` ADD `group_number` varchar(225) NOT NULL;");
    $this->db->query("ALTER TABLE `ac_vouchers` ADD `payment_term` varchar(225) NOT NULL;");
    $this->db->query("ALTER TABLE `ac_vouchers` ADD `from_group_name` varchar(225) NOT NULL;");
    $this->db->query("ALTER TABLE `ac_vouchers` ADD `to_group_name` int(225) NOT NULL;");
    $this->db->query("ALTER TABLE `ac_vouchers` ADD `from_group_id` int(11) NOT NULL;");
    $this->db->query("ALTER TABLE `ac_vouchers` ADD `to_group_id` int(11) NOT NULL;");
    $this->db->query("ALTER TABLE `ac_vouchers` ADD `has_hallmark` int(11) NOT NULL;");
    $this->db->query("ALTER TABLE `ac_vouchers` ADD `hallmark_number` decimal(10,4) NOT NULL;");

    $this->db->query("ALTER TABLE `ac_sales_purchase_repair_voucher` ADD `category` VARCHAR(225) NOT NULL;");
	 $this->db->query("ALTER TABLE `ac_sales_purchase_repair_voucher` ADD `moti_wt` DECIMAL(10,4) NOT NULL ;");
	 $this->db->query("ALTER TABLE `ac_sales_purchase_repair_voucher` ADD `melting` DECIMAL(10,4) NOT NULL ;");
	 $this->db->query("ALTER TABLE `ac_sales_purchase_repair_voucher` ADD `wastage` DECIMAL(10,4) NOT NULL ;");
	 $this->db->query("ALTER TABLE `ac_sales_purchase_repair_voucher` ADD `rate` DECIMAL(10,4) NOT NULL ;");
	 $this->db->query("ALTER TABLE `ac_sales_purchase_repair_voucher` ADD `gold_amount` DECIMAL(10,4) NOT NULL ;");
	 $this->db->query("ALTER TABLE `ac_sales_purchase_repair_voucher` ADD `labour_rate` DECIMAL(10,4) NOT NULL ;");
	 $this->db->query("ALTER TABLE `ac_sales_purchase_repair_voucher` ADD `other_charges` DECIMAL(10,4) NOT NULL ;");
	 $this->db->query("ALTER TABLE `ac_sales_purchase_repair_voucher` ADD `description` DECIMAL(10,4) NOT NULL ;");
  }


}

?>