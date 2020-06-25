<?php  
  // if (isset($balance[$voucher_date][$type])) {
  //   if ($label == 'Closing Stock') {
  //     $fine = $balance[$voucher_date][$type]['fine'] - $balance[$voucher_date][$type]['weight_difference'];
  //     if ($type == 'issue')
  //       $fine = -1 * $fine;
  //     $vadotar = 0;
  //   } elseif ($report == 'vadotar report') {
  //     $fine = 0;
  //     $vadotar = -1 * $balance[$voucher_date][$type]['weight_difference'];
  //   } elseif ($report == 'account ledger') {  
  //     $fine = $balance[$voucher_date][$type]['fine'];
  //     $vadotar = $balance[$voucher_date][$type]['weight_difference'];
  //     if ($type == 'issue') {
  //       $fine = -1 * $fine;
  //       $vadotar = -1 * $vadotar;
  //     }

  //   } else {
  //     $fine = $balance[$voucher_date][$type]['fine'];
  //     $vadotar = $balance[$voucher_date][$type]['weight_difference'];
  //   }

  //   $this->load->view('reports/ledgers/total', 
  //                         array('label' => $label,
  //                               'weight' => 0,
  //                               'fine' => 0,
  //                               'factory_fine' => $factory_fine,
  //                               'weight_difference' => $vadotar));
  // }
?>

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
      $fine = 0;
    } elseif ($report == 'account ledger') {
      $weight = 0;
      $fine = 0;
    }

    $this->load->view('reports/ledgers/total', 
                          array('report' => $report,
                                'label' => $label,
                                'weight' => $weight,
                                'fine' => $fine,
                                'factory_fine' => $factory_fine,
                                'weight_difference' => $weight_difference));
  }
?>