<?php  
	if (isset($balance[$voucher_date][$type])) {
		if($balance[$voucher_date][$type]=="receipt") 
			$this->load->view('reports/account_ledger_reports/total_issues', 
														array('label' => $label,
															    'weight_difference' => $balance[$voucher_date][$type]['weight_difference']));
		else
			$this->load->view('reports/account_ledger_reports/total_receipts', 
														array('label' => $label,
															    'weight_difference' => $balance[$voucher_date][$type]['weight_difference']));

	}
?>
