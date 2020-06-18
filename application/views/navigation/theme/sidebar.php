<?php
  $menu_icons = array('Users'=> 'mdi mdi-account-box',
                     'Rojmel'=> 'mdi mdi-bullseye',
                     'Masters' => 'fa fa-black-tie',
                     'Transaction' => 'fa fa-exchange',
                     'MIS Report' => 'fa fa-file-text',
                     'Stock Report' => 'fa fa-line-chart',
                     'Order Report' => 'fa fa-line-chart',
                     'Interest'     => 'fa fa-percent',
                     'Other'        => 'fa fa-question-circle');

  $main_menu =  array('Users'  => array('users/users'=>'Users',
                                      'users/user_roles'=>'User roles'),
                     // 'Rojmel'  => array('rojmel/rojmel'=>'Rojmel'),
                     'Masters' => array('masters/accounts'=>'Accounts',
                                        'masters/groups' =>'Group',
                                        'masters/sub_groups' =>'Sub Group',
                                        'masters/purity'=>'Purity',
                                        'masters/company'=>'Company',
                                        'masters/payment_terms'=>'Payment Terms',
                                        'masters/opening_balance'=>'Opening Balance',
                                        'masters/department'=>'Department',
                                        'masters/customer_category'=>'Customer Category',
                                        'masters/department_category'=>'Department Category',
                                        'masters/narrations'=>'Narrations',
                                        'masters/periods'=>'Financial Year',
                                        'masters/settings'=>'Settings'),
                    'Transactions' => array(
                                              // 'transactions/cash_receipt_vouchers' => 'Cash Voucher',//
                                             // 'transactions/bank_receipt_vouchers' => 'Bank Voucher',//
                                            'transactions/metal_receipt_vouchers' => 'Metal Voucher',
                                           //  'transactions/sales_vouchers' => 'Sales Voucher',//
                                           //  'transactions/purchase_vouchers' => 'Purchase Voucher',//
                                           //  'transactions/journal_vouchers' => 'Journal Voucher',//
                                           //  'transactions/contra_vouchers' => 'Contra Voucher',//
                                           // 'transactions/rate_cut_purchase_price_receipt_vouchers' => 'Rate Cut Purchase Price Voucher',//
                                           // 'transactions/rate_cut_purchase_weight_receipt_vouchers' => 'Rate Cut Purchase Weight Voucher',//
                                           // 'transactions/rate_cut_booking_price_receipt_vouchers' => 'Rate Cut Booking Price Voucher',//
                                           // 'transactions/rate_cut_booking_weight_receipt_vouchers' => 'Rate Cut Booking Weight Voucher',//

                                            // 'transactions/rate_cut_booking_price_issue_voucher' => 'Rate Cut Booking Price Issue Voucher',
                                            // 'transactions/rate_cut_booking_weight_issue_voucher' => 'Rate Cut Booking Weight Issue Voucher',
                                            // 'transactions/rate_cut_booking_price_receipt_voucher' => 'Rate Cut Booking Price Receipt Voucher',
                                            // 'transactions/rate_cut_booking_weight_receipt_voucher' => 'Rate Cut Booking Weight Receipt Voucher',
                                            // 'transactions/dispatch_voucher' => 'Dispatch Voucher',
                                            // 'transactions/repair_vouchers' => 'Repair Voucher',//
                                            // 'transactions/approval_vouchers' => 'Approval Voucher',//
                                            // 'transactions/expense_vouchers' => 'Expense Voucher',//
                                            // 'transactions/transfer_voucher' => 'Transfer Voucher',
                                            // 'transactions/repair_voucher_out' => 'Repair Voucher Out',
                                            // 'transactions/approval_in_voucher' => 'Approval in Voucher',
                                             // 'transactions/opening_stock_vouchers' => 'Opening Stock Voucher',//
                                             // 'transactions/sales_return_vouchers' => 'Sales Return Voucher',//
                                            // 'transactions/antique_sales_voucher' => 'Antique Sales Voucher',
                                            // 'transactions/mangalsutra_sales_voucher' => 'Mangalsutra Sales Voucher',
                                            // 'transactions/platinum_sales_voucher' => 'Platinum Sales Voucher',
                                            // 'transactions/machine_bangles_sales_voucher' => 'Machine Bangles Sales Voucher',
                                            // 'transactions/antique_sales_return_voucher' => 'Antique Sales Return Voucher',
                                            // 'transactions/mangalsutra_sales_return_voucher' => 'Mangalsutra Sales Return Voucher'
                                          ),
                    // 'Reports'   => array('reports/mis_reports'=>'MIS Reports',
                    //                     'reports/stock_report' =>'Stock Report',
                    //                     'reports/order_report'=>'Order Report'),
                    'Reports'   => array(
                                        // 'reports/account_ledger_reports' => 'Account Ledger',
                                        // 'reports/account_ledgers' => 'Account Ledger Report',
                                        // 'reports/outstanding_report' => 'Outstanding Report',
                                        'reports/client_account_ledger_reports' => 'Trial Balance',
                                        'reports/vadotar_reports' => 'Vadotar Report',
                                        'reports/rojmel_reports' => 'Rojmel Report'),
                    //'Interests' => array('transactions/interest_issue_vouchers'=>'Interest Issue Voucher','transactions/interest_receipt_vouchers'=>'Interest Receipt Voucher'),
                    'Registers'   => array(
                      'registers/cash_registers' => 'Cash Register',
                      'registers/bank_registers' => 'Bank Register',
                      'registers/metal_registers' => 'Metal Register',
                      'registers/sales_registers' => 'Sales Register',
                      'registers/purchase_registers' => 'Purchase Register',
                      'registers/rate_cut_purchase_value_registers' => 'Rate Cut Purchase Value Register',
                      'registers/rate_cut_purchase_weight_registers' => 'Rate Cut Purchase Weight Register',
                      'registers/rate_cut_booking_value_registers' => 'Rate Cut Booking Value Register',
                      'registers/rate_cut_booking_weight_registers' => 'Rate Cut Booking Weight Register',
                      'registers/expense_registers' => 'Expense Registers',
                                        ),
                    
                    'Others'    => array('others/account_wise_details'=>'Account Wise Details',
                                        'others/categories'=>'Category',
                                        'others/items'=>'Item',
                                        'others/cities'=>'City',
                                        'others/states'=>'State',
                                        'others/salesmans'=>'Sales Man',
                                        'others/books'=>'Book',
                                        'others/sms'=>'SMS'),

                ); 
  $this->load->view('navigation/application/sidebar', 
                  array('main_menu' => $main_menu, 'menu_icons' => $menu_icons)); 
?>



