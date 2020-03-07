<tbody>
  <?php 
    $this->load->view('reports/account_ledger_reports/balance', 
                      array('label' => 'Opening',
                           'voucher_date' => $previous_date,
                           'type' => $type));

    foreach ($voucher_date_records as $index => $record){
      if(!strpos($record['voucher_type'],'issue'))
        $this->load->view('reports/account_ledger_reports/tr_receipt', array('record' => $record));   
      else 
        $this->load->view('reports/account_ledger_reports/tr_issue', array('record' => $record));  
    } 
    
    if(!strpos($record['voucher_type'],'issue')) {
      $this->load->view('reports/account_ledger_reports/total_receipts', 
                        array('label' => 'Total',
                             'debit_weight' => $total[$voucher_date][$type]['debit_weight'], 
                             'weight_difference' => $total[$voucher_date][$type]['weight_difference']));

      $this->load->view('reports/account_ledger_reports/balance', 
                        array('label' => 'Balance',
                             'voucher_date' => $voucher_date,
                             'type' => $type));
    }
    else {
      $this->load->view('reports/account_ledger_reports/total_issues', 
                            array('label' => 'Total',
                                 'credit_weight' => $total[$voucher_date][$type]['credit_weight'],
                                 'weight_difference' => $total[$voucher_date][$type]['weight_difference']));
      $this->load->view('reports/account_ledger_reports/balance', 
                        array('label' => 'Balance',
                             'voucher_date' => $voucher_date,
                             'type' => $type));
    }


    



  ?>
</tbody>