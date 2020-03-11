<tbody>
  <?php 
    $this->load->view('reports/rojmel_reports/balance', 
                      array('label' => 'Opening',
                           'voucher_date' => $previous_date,
                           'type' => $type));

    foreach ($voucher_date_records as $index => $record){
      if(!strpos($record['voucher_type'],'issue'))
        $this->load->view('reports/rojmel_reports/tr_receipt', array('record' => $record));   
      else 
        $this->load->view('reports/rojmel_reports/tr_issue', array('record' => $record));  
    } 

    if(!strpos($type,'issue')) {
      $this->load->view('reports/rojmel_reports/total', 
                        array('label' => 'Total',
                             'weight' => $total[ACCOUNT_NAME_REPORT][$voucher_date][$type]['weight'], 
                             'weight_difference' => $total[ACCOUNT_NAME_REPORT][$voucher_date][$type]['weight_difference'],
                             'fine' => $total[ACCOUNT_NAME_REPORT][$voucher_date][$type]['fine'],
                             'factory_fine' => $total[ACCOUNT_NAME_REPORT][$voucher_date][$type]['factory_fine']));

      $this->load->view('reports/rojmel_reports/balance', 
                        array('label' => 'Balance',
                             'voucher_date' => $voucher_date,
                             'type' => $type));
    }
    else {
      $this->load->view('reports/rojmel_reports/total', 
                            array('label' => 'Total',
                                 'weight' => $total[ACCOUNT_NAME_REPORT][$voucher_date][$type]['weight'],
                                 'weight_difference' => $total[ACCOUNT_NAME_REPORT][$voucher_date][$type]['weight_difference'],
                                  'fine' => $total[ACCOUNT_NAME_REPORT][$voucher_date][$type]['fine'],
                                  'factory_fine' => $total[ACCOUNT_NAME_REPORT][$voucher_date][$type]['factory_fine'],
                                 ));
      $this->load->view('reports/rojmel_reports/balance', 
                        array('label' => 'Balance',
                             'voucher_date' => $voucher_date,
                             'type' => $type));
    }


    



  ?>
</tbody>