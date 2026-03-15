<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_columns_in_packing_slips extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `packing_slips`
								  DROP `packet_no`,
								  DROP `site_name`,
								  DROP `no_of_packets`,
								  DROP `packet_gross_weight`,
								  DROP `sale_type`,
								  DROP `rate`,
								  DROP `sgst_amount`,
								  DROP `cgst_amount`,
								  DROP `taxable_amount`,
								  DROP `manual_taxable_amount`,
								  DROP `discount`,
								  DROP `stone_amount`,
								  DROP `chitti_hide`,
								  DROP `ounce_rate`,
								  DROP `usd_rate`,
								  DROP `premium_rate`,
								  DROP `premium_usd_amount`,
								  DROP `labour_rate`,
								  DROP `labour_usd_amount`,
								  DROP `freight_usd_amount`,
								  DROP `taxable_usd_amount`,
								  DROP `ounce_gram_rate`,
								  DROP `product_rate`;");
    $this->db->query("ALTER TABLE `packing_slips` ADD `quantity` int(11) NULL DEFAULT '0',
    											  ADD `sr_no` int(11) NULL DEFAULT '0',
    											  ADD stone decimal(16,4) NULL DEFAULT '0',
    											  ADD net_weight decimal(16,4) NULL DEFAULT '0',
    											  ADD making_charge decimal(16,4) NULL DEFAULT '0',
    											  ADD pure decimal(16,4) NULL DEFAULT '0',
    											  ADD total decimal(16,4) NULL DEFAULT '0',
    											  ADD description varchar(500) NULL DEFAULT NULL,
    											  ADD colour varchar(100) NULL DEFAULT NULL");
    
  }


}

?>