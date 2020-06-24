<?php  
	if (isset($balance[$account_name][$voucher_date][$type])) {
		
		$this->load->view('reports/vadotar_reports/total', 
													array('label' => $label,
														    'weight_difference' => $balance[$account_name][$voucher_date][$type]['weight_difference'],
														  	'weight' => 0, //$balance[$account_name][$voucher_date][$type]['weight'],
														  	'fine' => 0, //$balance[$account_name][$voucher_date][$type]['fine'],
														  	'factory_fine' => 0)); //$balance[$account_name][$voucher_date][$type]['factory_fine']));

	}
?>
