<?php 
  if(!empty(get_field_attribute($this->router->class,'usd_debit_amount'))) :
    load_field('text', array('field' => 'usd_debit_amount')); 
  endif; 
?> 