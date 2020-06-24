<tbody>
  <?php 
    $this->load->view('reports/account_ledger_reports/balance', 
                      array('label' => 'Opening',
                           'voucher_date' => $previous_date,
                           'type' => $type));

    foreach ($voucher_date_records as $index => $record){
      if(strpos($record['voucher_type'],'receipt'))
        $this->load->view('reports/account_ledger_reports/tr_receipt', array('record' => $record));   
      else 
        $this->load->view('reports/account_ledger_reports/tr_issue', array('record' => $record));  
    } 
    
    if(strpos($type,'receipt')) {
      $this->load->view('reports/account_ledger_reports/total', 
                        array('label' => 'Total',
                             'weight' => $total[$account_name][$voucher_date][$type]['weight'], 
                             'weight_difference' => $total[$voucher_date][$type]['weight_difference'],
                             'fine' => @$total[$account_name][$voucher_date][$type]['fine'],
                             'factory_fine' => @$total[$account_name][$voucher_date][$type]['factory_fine']));

      $this->load->view('reports/account_ledger_reports/balance', 
                        array('label' => 'Balance',
                              'voucher_date' => $voucher_date,
                              'type' => $type));
    }
    else {
      $this->load->view('reports/account_ledger_reports/total', 
                            array('label' => 'Total',
                                 'weight' => $total[$account_name][$voucher_date][$type]['weight'],
                                 'weight_difference' => $total[$account_name][$voucher_date][$type]['weight_difference'],
                                 'fine' => @$total[$account_name][$voucher_date][$type]['fine'],
                                 'factory_fine' => @$total[$account_name][$voucher_date][$type]['factory_fine']));
      $this->load->view('reports/account_ledger_reports/balance', 
                        array('label' => 'Balance',
                             'voucher_date' => $voucher_date,
                             'type' => $type));
    }


    



  ?>
</tbody>