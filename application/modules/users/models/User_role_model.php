<?php
require_once APPPATH . "modules/core_users/models/Core_user_role_model.php";
class User_role_model extends Core_user_role_model {
  public function __construct($data=array()) {
    parent::__construct($data);
  }

  public function get_controller_list($module_name='') {
    $modules = array('Masters' => array('masters/accounts','masters/groups', 'masters/purity', 
                                        'masters/company','masters/payment_terms', 'masters/opening_balance',
                                        'masters/department','masters/customer_category', 
                                        'masters/department_category','masters/periods'),
                     'Transactions' => array('transactions/cash_issue_vouchers', 
                                            'transactions/cash_receipt_vouchers',
                                            'transactions/bank_issue_vouchers', 'transactions/bank_receipt_vouchers',
                                            'transactions/metal_issue_vouchers', 'transactions/metal_receipt_vouchers',
                                            'transactions/sales_vouchers', 'transactions/purchase_voucher', 'transactions/journal_vouchers',
                                            'transactions/contra_vouchers',
                                            'transactions/rate_cut_purchase_price_issue_voucher',
                                            'transactions/rate_cut_purchase_weight_issue_voucher',
                                            'transactions/rate_cut_purchase_price_receipt_voucher',
                                            'transactions/rate_cut_purchase_weight_receipt_voucher',
                                            'transactions/rate_cut_booking_price_issue_voucher',
                                            'transactions/rate_cut_booking_weight_issue_voucher',
                                            'transactions/rate_cut_booking_price_receipt_voucher',
                                            'transactions/rate_cut_booking_weight_receipt_voucher',
                                            'transactions/dispatch_voucher', 'transactions/repair_voucher',
                                            'transactions/approval_voucher', 
                                            'transactions/expense_vouchers',
                                            'transactions/transfer_voucher','transactions/repair_voucher_out',
                                            'transactions/approval_in_voucher', 'transactions/opening_stock_voucher',
                                            'transactions/sales_return_voucher', 'transactions/antique_sales_voucher',
                                            'transactions/mangalsutra_sales_voucher','transactions/platinum_sales_voucher',
                                            'transactions/machine_bangles_sales_voucher','transactions/antique_sales_return_voucher',
                                            'transactions/mangalsutra_sales_return_voucher'),
                     // 'Reports' => array('reports/mis_reports','reports/stock_report', 
                     //                    'reports/order_report'),
                     'Reports' => array('reports/account_ledger_reports',
                                        'reports/client_account_ledger_reports',
                                        'reports/vadotar_reports',
                                        'reports/rojmel_reports'),
                     'Interest' => array('interest/interest_issue_voucher'),
                     'Others' => array('others/account_wise_details','others/category', 'others/item', 
                                       'others/city','others/state', 'others/salesman', 'others/narration',
                                        'others/book', 'others/sms'),
                     'Users' => array('users/users','users/user_roles'));

    return (!empty($module_name) ? $modules[$module_name] : $modules);
  }
}