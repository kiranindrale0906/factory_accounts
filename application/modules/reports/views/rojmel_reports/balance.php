<?php  
	if (isset($balance[ACCOUNT_NAME_REPORT][$voucher_date][$type])) {
		if($balance[ACCOUNT_NAME_REPORT][$voucher_date][$type]=="receipt") 
			$this->load->view('reports/rojmel_reports/total_issues', 
														array('label' => $label,
																	'weight' => $balance[ACCOUNT_NAME_REPORT][$voucher_date][$type]['weight'],
															    'weight_difference' => $balance[ACCOUNT_NAME_REPORT][$voucher_date][$type]['weight_difference']));
		else
			$this->load->view('reports/rojmel_reports/total_receipts', 
														array('label' => $label,
																	'weight' => $balance[ACCOUNT_NAME_REPORT][$voucher_date][$type]['weight'],
															    'weight_difference' => $balance[ACCOUNT_NAME_REPORT][$voucher_date][$type]['weight_difference']));

	}
?>
