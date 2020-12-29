<tbody>
  <?php 
     if ($previous_date != '')
      $this->load->view('reports/ledgers/total', array('label' => 'Opening',
                                                       'record' => $opening[$voucher_date][$type]));

    if (!isset($detail) || $detail == 'yes') {
      foreach ($voucher_date_records as $index => $record) {
        if (($record['debit_weight'] != 0 || $record['debit_amount'] != 0))
          $this->load->view('reports/ledgers/tr_receipt', array('record' => $record));   
        elseif (($record['credit_weight'] != 0 || $record['credit_amount'] != 0)) 
          $this->load->view('reports/ledgers/tr_issue', array('record' => $record));  
      }
    } 

    $this->load->view('reports/ledgers/total', array('label' => 'Day Total',   'record' => $day_total[$voucher_date][$type]));   
    $this->load->view('reports/ledgers/total', array('label' => 'Day Balance', 'record' => $day_balance[$voucher_date][$type]));   
    $this->load->view('reports/ledgers/total', array('label' => 'Balance',     'record' => $balance[$voucher_date][$type]));   
    if (isset($closing[$voucher_date]))
      $this->load->view('reports/ledgers/total', array('label' => 'Closing',     'record' => $closing[$voucher_date][$type]));   
    
    // $this->load->view('reports/ledgers/total', 
    //                       array('report' => $report,
    //                             'type' => $type,
    //                             'label' => 'Total',
    //                             'weight' => $day_total[$voucher_date][$type]['weight'],
    //                             'weight_difference' => $day_total[$voucher_date][$type]['weight_difference'],
    //                             'fine' => @$day_total[$voucher_date][$type]['fine'],
    //                             'factory_fine' => @$day_total[$voucher_date][$type]['factory_fine'],
    //                             'amount' => $day_total[$voucher_date][$type]['amount']));

    // $this->load->view('reports/ledgers/closing', 
    //                   array('label' => 'Closing',
    //                         'voucher_date' => $voucher_date,
    //                         'type' => $type));

    // if ($report == 'rojmel report' || $report == 'vadotar report')
    //   $this->load->view('reports/ledgers/closing', 
    //                     array('label' => 'Closing Stock',
    //                           'voucher_date' => $voucher_date,
    //                           'type' => $type));

  ?>
</tbody>