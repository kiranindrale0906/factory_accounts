<?php  
	if (isset($balance[$account_name][$voucher_date][$type])) {
		
		$this->load->view('reports/client_account_ledger_reports/total', 
													array('label' => $label,
														    'weight_difference' => $balance[$account_name][$voucher_date][$type]['weight_difference'],
														  	'weight' => $balance[$account_name][$voucher_date][$type]['weight'],
														  	'fine' => $balance[$account_name][$voucher_date][$type]['fine'],
														  	'factory_fine' => $balance[$account_name][$voucher_date][$type]['factory_fine']));

	}
?>
