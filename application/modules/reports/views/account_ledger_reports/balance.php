<?php  
	if (isset($balance[$voucher_date][$type])) { 
		$this->load->view('reports/account_ledger_reports/total', 
													array('label' => $label,
														    'weight' => $balance[$voucher_date][$type]['weight']));

	}
?>
