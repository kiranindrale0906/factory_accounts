<?php 
  if(!empty(get_field_attribute($this->router->class,'usd_credit_amount'))) :
    load_field('text', array('field' => 'usd_credit_amount')); 
  endif; 
?> 