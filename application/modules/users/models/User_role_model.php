<?php
require_once APPPATH . "modules/core_users/models/Core_user_role_model.php";
class User_role_model extends Core_user_role_model {
  public function __construct($data=array()) {
    parent::__construct($data);
  }

  public function get_controller_list($module_name='') {
    $modules = array('Masters' => array('masters/accounts','masters/groups','masters/sub_groups', 'masters/purity', 
                                        'masters/company','masters/payment_terms', 'masters/opening_balance',
                                        'masters/department','masters/customer_category','masters/settings', 
                                        'masters/department_category','masters/periods',
                                        'masters/narrations','masters/periods'),
                     'Transactions' => array('transactions/cash_issue_vouchers', 
                                            'transactions/cash_receipt_vouchers',
                                            'transactions/bank_issue_vouchers', 'transactions/bank_receipt_vouchers',
                                            'transactions/metal_issue_vouchers', 'transactions/metal_receipt_vouchers',
                                            'transactions/metal_issue_voucher_details', 'transactions/metal_receipt_voucher_details',
                                            'transactions/sales_vouchers', 'transactions/purchase_vouchers', 
                                            'transactions/journal_vouchers', 'transactions/contra_vouchers',
                                            'transactions/rate_cut_receipt_vouchers', 'transactions/rate_cut_issue_vouchers',
                                            'argold/metal_receipt_gold_rates',
                                            'transactions/dispatch_voucher', 'transactions/repair_vouchers',
                                            'transactions/approval_vouchers', 
                                            'transactions/expense_vouchers',
                                            'transactions/transfer_voucher','transactions/repair_voucher_out',
                                            'transactions/approval_in_voucher', 'transactions/opening_stock_vouchers',
                                            'transactions/sales_return_vouchers', 'transactions/antique_sales_voucher',
                                            'transactions/mangalsutra_sales_voucher',
                                            'transactions/platinum_sales_voucher',
                                            'transactions/machine_bangles_sales_voucher',
                                            'transactions/antique_sales_return_voucher',
                                            'transactions/interest_issue_vouchers',
                                            'transactions/interest_receipt_vouchers',
                                            'argold/chittis','argold/voucher_details',
                                            'argold/refresh','argold/refresh_details',
                                            'transactions/mangalsutra_sales_return_voucher'),
                     // 'Reports' => array('reports/mis_reports','reports/stock_report', 
                     //                    'reports/order_report'),
                     'Reports' => array('reports/account_ledgers',
                                        'reports/outstanding_report',
                                        'reports/trial_balances',
                                        'reports/vadotar_reports',
                                        'reports/rojmel_reports',
                                        'reports/bw_accounts',
                                        'reports/production_summary'),
                     'Interest' => array('interest/interest_issue_voucher'),
                     'Registers' => array('registers/cash_registers','registers/bank_registers','registers/sales_registers','registers/purchase_registers','registers/rate_cut_purchase_value_registers','registers/rate_cut_purchase_weight_registers','registers/rate_cut_booking_value_registers','registers/rate_cut_booking_weight_registers','registers/expense_registers','registers/metal_registers'),
                     'Others' => array('others/account_wise_details','others/categories', 'others/items', 
                                       'others/cities','others/states', 'others/salesmans', 'others/narrations',
                                        'others/books', 'others/sms'),
                     'Users' => array('users/users','users/user_roles'),
                      'Migrations' => array('sys/migrations'),
                     'api' => array('api/api_metal_issue_vouchers'));

    return (!empty($module_name) ? $modules[$module_name] : $modules);
  }
}