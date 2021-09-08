<?php 
  if(!empty(get_field_attribute($this->router->class,'cash_amount'))) :
    load_field('text', array('field' => 'cash_amount')); 
  endif; 
?> 