<?php  
  if (isset($balance[$voucher_date][$type])) {
    $weight = $balance[$voucher_date][$type]['weight'];
    $fine = $balance[$voucher_date][$type]['fine'];
    $factory_fine = $balance[$voucher_date][$type]['factory_fine'];
    $vadotar = $balance[$voucher_date][$type]['weight_difference'];
    $amount = $balance[$voucher_date][$type]['amount'];

    if ($report == 'vadotar report' && $label == 'Closing Stock') {
      $weight = 0;
      $fine = 0;
      $factory_fine = 0;
    } elseif ($report == 'rojmel report' && $label == 'Closing Stock') {
      $weight = 0;
      if ($type == 'receipt') {
        $factory_fine = 0;
        $fine = $fine + $weight_difference;
      } else {
        $fine = 0;
        $factory_fine = $factory_fine - $weight_difference;
      }
      $weight_difference = 0;
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
                                'weight_difference' => $weight_difference,
                                'amount' => $amount));
  }
?>