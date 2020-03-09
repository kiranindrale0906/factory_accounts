<?php  
	if (isset($balance[ACCOUNT_NAME_REPORT][$voucher_date][$type])) {
			$this->load->view('reports/rojmel_reports/total', 
														array('label' => $label,
																	'weight' => $balance[ACCOUNT_NAME_REPORT][$voucher_date][$type]['weight'],
															    'weight_difference' => $balance[ACCOUNT_NAME_REPORT][$voucher_date][$type]['weight_difference']
															  ));

	}
?>
