<?php  
	if (isset($balance[ACCOUNT_NAME_REPORT][$voucher_date][$type])) {
		  //pd($balance);
			$this->load->view('reports/rojmel_reports/total', 
														array('label' => $label,
																	'weight' => $balance[ACCOUNT_NAME_REPORT][$voucher_date][$type]['weight'],
															    'weight_difference' => $balance[ACCOUNT_NAME_REPORT][$voucher_date][$type]['weight_difference'],
															    'fine' => $balance[ACCOUNT_NAME_REPORT][$voucher_date][$type]['fine'],
														  		'factory_fine' => $balance[ACCOUNT_NAME_REPORT][$voucher_date][$type]['factory_fine']));

	}
?>
