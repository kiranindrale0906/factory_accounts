<?php
	$receipt_type=($this->router->class=='metal_issue_vouchers')?get_issue_type():get_receipt_type();
	if(!empty(get_field_attribute($this->router->class,'receipt_type'))) :
    load_field('dropdown', array('field' => 'receipt_type', 
                                 'option' => $receipt_type,
                                 'class' =>'receipt_type')); 
      
    load_field('hidden', array('field' => 'account_id'));                               
  endif; 
?>