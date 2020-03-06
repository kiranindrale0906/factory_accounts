<tbody>
  <?php 
    $this->load->view('reports/account_ledger_reports/balance', array('label' => 'Opening',
                                                                             'voucher_date' => $previous_date,
                                                                             'type' => $type));

    foreach ($voucher_date_records as $index => $record){
      if(!strpos($record['voucher_type'],'issue'))
        $this->load->view('reports/account_ledger_reports/tr_receipt', array('record' => $record));   
      else 
        $this->load->view('reports/account_ledger_reports/tr_issue', array('record' => $record));  
    } 
  
    // $this->load->view('reports/account_ledger_reports/total', array('label' => 'Total',
    //                                                                        'weight' => $total[$voucher_date][$type]['weight'], 
    //                                                                        'purity' => $total[$voucher_date][$type]['purity']));
    // $this->load->view('reports/account_ledger_reports/balance', array('label' => 'Balance',
    //                                                                          'voucher_date' => $voucher_date,
    //                                                                          'type' => $type));



  ?>
</tbody>