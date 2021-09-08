<?php
	if(!empty(get_field_attribute($this->router->class,'dd_type'))) :
    load_field('dropdown', array('field' => 'dd_type', 
                                 'option' => get_daily_drawer_receipt_type(),
                                 'class' =>'dd_type')); 
      
    load_field('hidden', array('field' => 'account_id'));                               
  endif; 
?>