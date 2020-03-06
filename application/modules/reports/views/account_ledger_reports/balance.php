<?php  
	if (isset($balance[$created_date][$type])) { 
		$this->load->view('issue_and_receipts/issue_and_receipts/total', 
													array('label' => $label,
														    'weight' => $balance[$created_date][$type]['weight'], 
														    'fine' => $balance[$created_date][$type]['fine']));
	}
?>
