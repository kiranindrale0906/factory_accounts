<tbody>
  <?php 
    $this->load->view('reports/ledgers/balance', array('report' => $report,
                                                       'label' => 'Opening',
                                                       'voucher_date' => $previous_date,
                                                       'type' => $type));

    if (!isset($detail) || $detail == 'yes') {
      foreach ($voucher_date_records as $index => $record) {
        if($record['debit_weight'] > 0 || $record['debit_amount'] > 0)
          $this->load->view('reports/ledgers/tr_receipt', array('record' => $record));   
        else 
          $this->load->view('reports/ledgers/tr_issue', array('record' => $record));  
      }
    } 

    $this->load->view('reports/ledgers/total', 
                          array('report' => $report,
                                'type' => $type,
                                'label' => 'Total',
                                'weight' => $total[$voucher_date][$type]['weight'],
                                'weight_difference' => $total[$voucher_date][$type]['weight_difference'],
                                'fine' => @$total[$voucher_date][$type]['fine'],
                                'factory_fine' => @$total[$voucher_date][$type]['factory_fine']));

    $this->load->view('reports/ledgers/closing', 
                      array('label' => 'Closing',
                            'voucher_date' => $voucher_date,
                            'type' => $type));

    if ($report == 'rojmel report' || $report == 'vadotar report')
      $this->load->view('reports/ledgers/closing', 
                        array('label' => 'Closing Stock',
                              'voucher_date' => $voucher_date,
                              'type' => $type));

  ?>
</tbody>