<?php  
	if (isset($balance[$account_name][$voucher_date][$type])) {
		if($balance[$account_name][$voucher_date][$type]=="receipt") 
			$this->load->view('reports/client_account_ledger_reports/total', 
														array('label' => $label,
															    'weight_difference' => $balance[$account_name][$voucher_date][$type]['weight_difference'],
															  	'weight' => $balance[$account_name][$voucher_date][$type]['weight']));
		else
			$this->load->view('reports/client_account_ledger_reports/total', 
														array('label' => $label,
															    'weight_difference' => $balance[$account_name][$voucher_date][$type]['weight_difference'],
															  	'weight' => $balance[$account_name][$voucher_date][$type]['weight']));

	}
?>
