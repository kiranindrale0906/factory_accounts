<?php  
	if (isset($balance[$voucher_date][$type])) {
			$this->load->view('reports/ledgers/total', 
														array('report' => $report,
                                  'label' => $label,
																	'weight' => $balance[$voucher_date][$type]['weight'],
															  	'fine' => $balance[$voucher_date][$type]['fine'],
														  		'factory_fine' => $balance[$voucher_date][$type]['factory_fine'],
                                  'weight_difference' => $balance[$voucher_date][$type]['weight_difference']));
	}
?>