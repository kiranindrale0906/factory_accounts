<?php  
  if (isset($balance[$voucher_date][$type])) {
    if ($label == 'Closing Stock') {
      $fine = $balance[$voucher_date][$type]['fine'] - $balance[$voucher_date][$type]['weight_difference'];
      if ($type == 'issue')
        $fine = -1 * $fine;
      $vadotar = 0;
    } elseif ($report == 'vadotar report') {
      $fine = 0;
      $vadotar = -1 * $balance[$voucher_date][$type]['weight_difference'];
    } elseif ($report == 'account ledger') {  
      $fine = $balance[$voucher_date][$type]['fine'];
      $vadotar = $balance[$voucher_date][$type]['weight_difference'];
      if ($type == 'issue') {
        $fine = -1 * $fine;
        $vadotar = -1 * $vadotar;
      }

    } else {
      $fine = $balance[$voucher_date][$type]['fine'];
      $vadotar = $balance[$voucher_date][$type]['weight_difference'];
    }

    $this->load->view('reports/ledgers/total', 
                          array('label' => $label,
                                'weight' => 0,
                                'fine' => $fine,
                                'factory_fine' => 0,
                                'weight_difference' => $vadotar));
  }
?>
