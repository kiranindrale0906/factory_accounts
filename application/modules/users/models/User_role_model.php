<?php
require_once APPPATH . "modules/core_users/models/Core_user_role_model.php";
class User_role_model extends Core_user_role_model {
  public function __construct($data=array()) {
    parent::__construct($data);
  }

  public function get_controller_list($module_name='') {
    $modules = array('Masters' => array('masters/accounts','masters/groups','masters/sub_groups', 'masters/purity', 
                                        'masters/company','masters/payment_terms', 'masters/opening_balance',
                                        'masters/department','masters/customer_category','masters/settings', 'masters/account_listing','masters/quators',
                                        'masters/department_category','masters/periods',
                                        'masters/narrations','masters/periods','masters/empty_packets',
                                          'masters/empty_bags'),
                     'Transactions' => array('transactions/cash_issue_vouchers', 
                                            'transactions/cash_receipt_vouchers',
                                            'transactions/bank_issue_vouchers', 'transactions/bank_receipt_vouchers',
                                            'transactions/metal_issue_vouchers', 'transactions/metal_receipt_vouchers',
                                            'transactions/metal_issue_voucher_details', 'transactions/metal_receipt_voucher_details',
                                            'transactions/sales_vouchers', 'transactions/purchase_vouchers', 
                                            'transactions/journal_vouchers', 'transactions/contra_vouchers',
                                            'transactions/rate_cut_receipt_vouchers', 'transactions/rate_cut_issue_vouchers',
                                            'argold/metal_receipt_gold_rates',
                                            'argold/ghiss_melting_quators',
                                            'argold/metal_issue_account_names',
                                            'transactions/dispatch_voucher', 'transactions/repair_vouchers',
                                            'transactions/approval_vouchers', 
                                            'transactions/expense_vouchers',
                                            'transactions/transfer_vouchers','transactions/repair_voucher_out',
                                            'transactions/approval_in_voucher', 'transactions/opening_stock_vouchers',
                                            'transactions/sales_return_vouchers', 'transactions/antique_sales_voucher',
                                            'transactions/mangalsutra_sales_voucher',
                                            'transactions/platinum_sales_voucher',
                                            'transactions/machine_bangles_sales_voucher',
                                            'transactions/antique_sales_return_voucher',
                                            'transactions/interest_issue_vouchers',
                                            'transactions/interest_receipt_vouchers',
                                            'argold/chittis',
                                            'argold/chalans',
                                            'argold/chalan_details',
                                            'argold/combine_chitties',
                                            'argold/combine_chitti_details',
                                            'argold/domestic_labour_chitties',
                                            'argold/domestic_labour_chitti_details',
                                            'argold/packing_slips','argold/chitti_exports','argold/metal_issue_chitties','argold/packing_slip_details','argold/metal_issue_packing_slips','argold/voucher_details',
                                            'argold/refresh','argold/chitti_empty_packet_details','argold/refresh_details','argold/chitti_hides','argold/refresh_hides',
                                            'transactions/loss_outs',
                                            'transactions/mangalsutra_sales_return_voucher',
                                            'ac_vouchers/voucher_listing',
                                            'argold/unrecovarable_account_records',
                                            'argold/ghiss_melting_quators',
                                            'argold/chitti_actual_weights',
                                            'argold/change_account_names'),
                     // 'Reports' => array('reports/mis_reports','reports/stock_report', 
                     //                    'reports/order_report'),
                     'Reports' => array('reports/account_ledgers',
                                        'reports/outstanding_report',
                                        'reports/trial_balances',
                                        'reports/vadotar_reports',
                                        'reports/account_receipt_reports',
                                        'reports/rojmel_reports',
                                        'reports/metal_receipt_type_ledgers',
                                        'reports/bw_accounts',
                                        'reports/production_summary',
                                        'reports/loss_accounts',
                                        'reports/loss_summaries',
                                        'reports/loss_reports',
                                        'reports/category_wise_loss_reports',
                                        'reports/loss_report_details',
                                        'reports/quator_wise_loss_reports',
                                        'reports/quator_wise_loss_report_details',
                                        'reports/loss_account_details',
                                        'reports/purchase_registers',
                                        'reports/sales_registers',
                                        'reports/cash_gst_registers',
                                        'reports/domestic_export_ledgers',
                                        ),
                     'Interest' => array('interest/interest_issue_voucher'),
                     'Registers' => array('registers/cash_registers','registers/bank_registers','registers/sales_registers','registers/purchase_registers','registers/rate_cut_purchase_value_registers','registers/rate_cut_purchase_weight_registers','registers/rate_cut_booking_value_registers','registers/rate_cut_booking_weight_registers','registers/expense_registers','registers/metal_registers'),
                     'Others' => array('others/account_wise_details','others/categories', 'others/items', 
                                       'others/cities','others/states', 'others/salesmans', 'others/narrations',
                                        'others/books', 'others/sms'),
                     'Users' => array('users/users','users/user_roles','users/ip_addresses','users/change_password',),
                     'Qr_Code' => array('qr_codes/qr_codes','qr_codes/Qr_code_details','qr_codes/design_details'),
                     'Migrations' => array('sys/migrations'),
                     'api' => array('api/api_metal_issue_vouchers','api/api_chittis'));
    $bk_modules= array('database_restore'=>array('masters/mysqldump'));
    $report_modules= array('Reports' => array(
                                        'reports/trial_balances'
                                        ));
    if(HOST=='BACKUP ACCOUNTS') {
      $modules = array_merge($modules,$bk_modules);
    } 
    if(HOST=='REPORT ACCOUNTS') {
      $modules = array_merge($modules,$report_modules);
    }    
    return (!empty($module_name) ? $modules[$module_name] : $modules);
  }
}