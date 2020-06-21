<?php
	if(!empty(get_field_attribute($this->router->class,'receipt_type'))) :
    load_field('dropdown', array('field' => 'receipt_type', 
                                 'option' => get_receipt_type(),
                                 'class' =>'receipt_type')); 
      
    load_field('hidden', array('field' => 'account_id'));                               
  endif; 
?>