<?php  
	if (isset($balance[ACCOUNT_NAME_REPORT][$voucher_date][$type])) {
			$this->load->view('reports/account_ledger_reports/total', 
														array('label' => $label,
																	'weight' => 0,
															    'weight_difference' => 0,
															  	'fine' => $balance[ACCOUNT_NAME_REPORT][$voucher_date][$type]['fine'],
														  		'factory_fine' => 0));
	}
?>
