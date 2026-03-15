<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_field_created_by extends CI_Model {

  public function up()
  {
  	//ac_sales_cash_voucher_mapping
    $fields = array('ac_account','ac_account_wise_details','ac_admin_controllers_mapping','ac_approval_repaire_voucher','ac_book','ac_category','ac_city','ac_company','ac_controllers','ac_customer_category','ac_department','ac_department_category','ac_designs','ac_dispatch_metal_details','ac_expense_voucher','ac_groups','ac_hallmark_details','ac_interest_voucher','ac_item','ac_item_mapping','ac_journal_voucher','ac_ledger','ac_menu','ac_metal_voucher','ac_narration','ac_opening_balance','ac_payment_terms','ac_product_category','ac_purity','ac_rate_cut_voucher','ac_salary_voucher','ac_salesman','ac_sales_cash_voucher_mapping','ac_sales_dispatch_mapping','ac_sales_purchase_details','ac_sales_purchase_item_details','ac_sales_purchase_repair_details','ac_sales_purchase_repair_voucher','ac_sales_purchase_voucher','ac_sms','ac_state','ac_transfer_voucher','ac_users','ac_user_department_mapping','ac_user_roles','ac_vouchers');

    foreach ($fields as $table_name) {
      $sql="alter table ".$table_name." add created_by int(11) default 0";
      //$this->db->query($sql);
    }
  }


}

?>