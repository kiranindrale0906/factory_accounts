<?php  
  if (isset($balance[$voucher_date][$type])) {
    $weight = $balance[$voucher_date][$type]['weight'];
    $fine = $balance[$voucher_date][$type]['fine'];
    $factory_fine = $balance[$voucher_date][$type]['factory_fine'];
    $vadotar = $balance[$voucher_date][$type]['weight_difference'];

    if ($report == 'vadotar report' && $label == 'Closing Stock') {
      $weight = 0;
      $fine = 0;
      $factory_fine = 0;
    } elseif ($report == 'rojmel report' && $label == 'Closing Stock') {
      $weight = 0;
      $factory_fine = $fine;
      $fine = 0;
    } elseif ($report == 'account ledger') {
      $weight = 0;
      $factory_fine = 0;
    }

    $this->load->view('reports/ledgers/total', 
                          array('report' => $report,
                                'type' => $type,
                                'label' => $label,
                                'weight' => $weight,
                                'fine' => $fine,
                                'factory_fine' => $factory_fine,
                                'weight_difference' => $weight_difference));
  }
?>