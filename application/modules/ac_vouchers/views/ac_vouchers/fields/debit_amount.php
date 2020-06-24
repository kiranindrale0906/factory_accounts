<?php 
  if(!empty(get_field_attribute($this->router->class,'debit_amount'))) :
    load_field('text', array('field' => 'debit_amount', 'readonly' => $data['readonly'])); 
  endif; 
?> 